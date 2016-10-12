<?php

class Luna_Github_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $username = $this->getRequest()->get('username');
        $type = ($this->getRequest()->get('type') ?: 'owner');
        $sort = ($this->getRequest()->get('sort') ?: 'full_name');

        if ($sort === 'full_name' && null === $this->getRequest()->get('direction')) {
            $direction = 'asc';
        } elseif ($sort !== 'full_name' && null === $this->getRequest()->get('direction')) {
            $direction = 'desc';
        } else {
            $direction = $this->getRequest()->get('direction');
        }

        if (is_null($username)) {
            $this->norouteAction();
            return;
        }

        $response = Mage::helper('github')->repositories()->getUserRepos($username, [
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction
        ]);

        echo (string) $response->getBody();
    }
}