<?php

class Luna_Github_Adminhtml_RequestController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Main log overview page
     */
    public function indexAction()
    {
        $this->_title($this->__('System'))->_title($this->__('Github API Requests'));
        $this->loadLayout();
        $this->_setActiveMenu('system');
        $this->_addContent($this->getLayout()->createBlock('luna_github/adminhtml_github_request'));
        $this->renderLayout();
    }

    /**
     * The grid containing the log entries
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('luna_github/adminhtml_github_request_grid')->toHtml()
        );
    }
}