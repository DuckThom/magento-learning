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

    public function getUserRepos($username, $params = [])
    {
        $url = $this->buildUrl($this->endpoints['user_repos'], [
            'username' => $username
        ]);

        return $this->get($url, $params);
    }

}