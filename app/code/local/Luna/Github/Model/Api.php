<?php

use GuzzleHttp\Client;

abstract class Luna_Github_Model_Api implements Luna_Github_Interfaces_Model_Api
{
    /**
     * Root endpoint for the GitHub API
     */
    const GITHUB_ROOT_ENDPOINT = 'https://api.github.com';

    /**
     * GitHub API version to use
     */
    const GITHUB_API_VERSION = 'v3';

    /**
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var array
     */
    protected $endpoints = [];

    /**
     * Luna_Github_Helper_Abstract constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::GITHUB_ROOT_ENDPOINT
        ]);

        $this->parameters = [
            'http_errors' => false,
            'headers' => [
                'Authorization' => ($this->hasApiKey() ? Mage::getStoreConfig('github/api_settings/api_key') : null)
            ]
        ];
    }

    /**
     * Alias for buildUri
     *
     * @param  string  $uri
     * @param  array  $values
     * @return bool|string
     */
    public function buildUrl($uri, $values)
    {
        return $this->buildUri($uri, $values);
    }

    /**
     * Build the API uri
     *
     * @param  string  $uri
     * @param  array  $values
     * @return bool|string
     */
    public function buildUri($uri, $values)
    {
        return $this->bindParam($uri, $values, [
            'separator' => '/',
            'prefix' => ':'
        ]);
    }

    /**
     * Get the base url for the api
     *
     * @param  string  $uri
     * @return string
     */
    public function getApiUrl($uri = '')
    {
        return self::GITHUB_BASE_URL . $uri;
    }

    /**
     * @param  string  $uri
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, $params = [])
    {
        $options['query'] = $params;

        return $this->request('GET', $uri, $options);
    }

    /**
     * Set and return the request headers
     *
     * @param  array  $headers
     * @return $this
     */
    public function setHeaders($headers)
    {
        $this->parameters['headers'] = array_merge($this->parameters['headers'], $headers);

        return $this;
    }

    /**
     * Perform the request
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $options
     * @return mixed
     */
    public function request($method, $uri, $options = [])
    {
        $parameters = array_merge($this->parameters, $options);

        self::logRequest($method, $parameters, $uri);

        $_response = $this->client->request($method, $uri, $parameters);
        $_statusCode = $_response->getStatusCode();
        $method = "_parse{$_statusCode}Response";

        // Try to use a parser for a specific HTTP code
        if (method_exists(static::class, $method)) {
            return $this->$method($_response);
        }

        // Fallback to general response handling
        return $this->_parseResponse($_response);
    }

    /**
     * Override this method to parse the response
     *
     * @param  mixed|\Psr\Http\Message\ResponseInterface  $response
     * @return mixed
     */
    protected function _parseResponse($response)
    {
        return $response;
    }

    /**
     * Bind an array of values to parameters in a string
     *
     * @param  string  $source
     * @param  array  $values
     * @param  array  $options
     * @return bool|string
     */
    public function bindParam($source, $values, $options = [])
    {
        if (!is_string($source)) {
            return false;
        }

        foreach ($values as $param => $value) {
            $this->_bindParam($source, $param, $value, $options);
        }

        return $source;
    }

    /**
     * Bind a value to a parameter in a string
     *
     * @param  string  $source
     * @param  string  $param
     * @param  string  $value
     * @param  array  $options
     * @return void
     */
    protected function _bindParam(&$source, $param, $value, $options = [])
    {
        if (!is_string($source) || !is_string($param)) {
            return;
        }

        $separator = ($options['separator'] ?: '/');
        $prefix = ($options['prefix'] ?: ':');

        $mappedArray = array_map(function ($item) use ($param, $value, $prefix) {
            return ($item === "{$prefix}{$param}" ? $value : $item);
        }, explode($separator, $source));

        $source = implode($separator, $mappedArray);
    }

    /**
     * Get the value of an endpoint
     *
     * @param  string  $alias
     * @return string|bool
     */
    public function getEndpoint($alias)
    {
        return ($this->endpoints[$alias] ?: false);
    }

    /**
     * Check if the api key has been set in the config
     *
     * @return bool
     */
    public function hasApiKey()
    {
        return (bool) Mage::getStoreConfig('github/api_settings/api_key');
    }

    /**
     * Log an API request to the database
     *
     * @param  string  $method
     * @param  array  $params
     * @param  string  $endpoint
     */
    public static function logRequest($method, $params, $endpoint)
    {
        $data = [
            'method' => $method,
            'params' => json_encode($params),
            'endpoint' => $endpoint,
            'client' => ($_SERVER['HTTP_X_FORWARDED_FOR'] ?: $_SERVER['REMOTE_ADDR'])
        ];

        $item = new Varien_Object();
        $item->setData($data);

        $log = Mage::getModel('luna_github/log_request');
        $log->setData($data);
        $log->save();
    }
}