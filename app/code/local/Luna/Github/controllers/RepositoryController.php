<?php

class Luna_Github_RepositoryController extends Mage_Core_Controller_Front_Action
{

    public function findByUserAction()
    {
        $username = $this->getRequest()->getParam('username');
        $type = $this->getRequest()->getParam('type', 'owner');
        $sort = $this->getRequest()->get('sort', 'full_name');

        if ($sort === 'full_name' && null === $this->getRequest()->getParam('direction')) {
            $direction = 'asc';
        } elseif ($sort !== 'full_name' && null === $this->getRequest()->getParam('direction')) {
            $direction = 'desc';
        } else {
            $direction = $this->getRequest()->getParam('direction');
        }

        if (is_null($username)) {
            $this->norouteAction();
            return;
        }

        $response = Mage::helper('luna_github')->repositories()->getUserRepos($username, [
            'type' => $type,
            'sort' => $sort,
            'direction' => $direction
        ]);

        echo (string) $response->getBody();
    }

}