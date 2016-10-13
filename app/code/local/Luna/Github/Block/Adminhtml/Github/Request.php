<?php

class Luna_Github_Block_Adminhtml_Github_Request extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'luna_github';
        $this->_controller = 'adminhtml_github_request';
        $this->_headerText = Mage::helper('luna_github')->__('Github - Request');

        parent::__construct();
        $this->_removeButton('add');
    }
}