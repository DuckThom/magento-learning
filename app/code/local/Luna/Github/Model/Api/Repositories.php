<?php

class Luna_Github_Model_Api_Repositories extends Luna_Github_Model_Api
{

    /**
     * @var array
     */
    protected $endpoints = [
        'own_repos' => '/user/repos',
        'user_repos' => '/users/:username/repos',
        'org_repos' => '/orgs/:org/repos',
        'all_repos' => '/repositories',
        'get_repo' => '/repos/:owner/:repo'
    ];

    /**
     * @param  string  $username
     * @param  array  $params
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUserRepos($username, $params = [])
    {
        $url = $this->buildUrl($this->endpoints['user_repos'], [
            'username' => $username
        ]);

        return $this->get($url, $params);
    }

    /**
     * Parse a HTTP 200 request
     *
     * @param  mixed|\Psr\Http\Message\ResponseInterface  $response
     * @return mixed
     */
    protected function _parse200Response($response)
    {
        $_jsonResponse = json_decode($response->getBody());
        $_collection = new Varien_Data_Collection();

        foreach ($_jsonResponse as $repo) {
            $repoObject = new Varien_Object();

            foreach ($repo as $key => $value) {
                $repoObject->setData($key, $value);
            }

            $_collection->addItem($repoObject);
        }

        return $_collection;
    }

}