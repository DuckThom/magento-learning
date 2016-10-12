<?php

interface Luna_Github_Interfaces_Model_Api
{

    /**
     * Luna_Github_Interfaces_Model_Api constructor.
     */
    public function __construct();

    /**
     * @param  string  $uri
     * @param  array  $values
     * @return string
     */
    public function buildUrl($uri, $values);

    /**
     * @param  string  $uri
     * @param  array  $values
     * @return string
     */
    public function buildUri($uri, $values);

    /**
     * @param  string  $uri
     * @return string
     */
    public function getApiUrl($uri = '');

    /**
     * @param  string  $uri
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function get($uri, $params = []);

    /**
     * @param  array  $headers
     * @return $this
     */
    public function setHeaders($headers);

    /**
     * @param  string  $method
     * @param  string  $uri
     * @param  array  $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request($method, $uri, $options = []);

    /**
     * @param  string  $source
     * @param  array  $values
     * @param  array $options
     * @return string|bool
     */
    public function bindParam($source, $values, $options = []);

    /**
     * @param  string  $alias
     * @return string|false
     */
    public function getEndpoint($alias);

    /**
     * @return bool
     */
    public function hasApiKey();

}