<?php

class Luna_Github_Helper_Repositories extends Luna_Github_Helper_Abstract
{

    const USER_URL = '/user/repos';
    const SPECIFIC_USER_URL = '/users/:username/repos';
    const ORGANISATION_URL = '/orgs/:org/repos';
    const ALL_REPOSITORIES_URL = '/repositories';
    const REPO_URL = '/repos/:owner/:repo';

    public function getUserRepos($username, $params = [])
    {
        $url = $this->buildUrl(self::SPECIFIC_USER_URL, [
            'username' => $username
        ]);

        return $this->get($url, $params);
    }

}