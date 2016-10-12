<?php

use GuzzleHttp\Client;

abstract class Luna_Github_Model_Api
{
    const GITHUB_BASE_URL = 'https://api.github.com';
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
     * @var
     */
    protected $endpoints = [];

    /**
     * Luna_Github_Helper_Abstract constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => self::GITHUB_BASE_URL
        ]);

        $this->parameters = [
            'http_errors' => false,
            'headers' => []
        ];
    }

    /**
     * Alias for buildUri
     *
     * @param  string  $url
     * @param  array  $values
     * @return bool|string
     */
    public function buildUrl($url, $values)
    {
        return $this->buildUri($url, $values);
    }

    /**
     * Build the API uri
     *
     * @param  string  $url
     * @param  array  $values
     * @return bool|string
     */
    public function buildUri($url, $values)
    {
        return $this->bindParam($url, $values, [
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
    protected function getApiUrl($uri = '')
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
     * @return array
     */
    protected function setHeaders($headers)
    {
        $this->parameters['headers'] = $headers;
    }

    /**
     * Perform the request
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function request($method, $uri, $options = [])
    {
        $parameters = array_merge($this->parameters, $options);

        return $this->client->request($method, $uri, $parameters);
    }

    /**
     * Bind an array of values to parameters in a string
     *
     * @param  string  $source
     * @param  array  $values
     * @param  array  $options
     * @return bool|string
     */
    protected function bindParam($source, $values, $options = [])
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
    protected function getEndpoint($alias)
    {
        return ($this->endpoints[$alias] ?: false);
    }
}