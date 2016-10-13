<?php

class Luna_Github_Block_Adminhtml_Github_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('github_request_grid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('luna_github/log_request_collection');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('luna_github');

        $this->addColumn('id', array(
            'header' => $helper->__('Request #'),
            'index'  => 'id'
        ));

        $this->addColumn('method', array(
            'header' => $helper->__('Method'),
            'index'  => 'method'
        ));

        $this->addColumn('params', array(
            'header'       => $helper->__('Parameters'),
            'index'        => 'params'
        ));

        $this->addColumn('endpoint', array(
            'header'       => $helper->__('Endpoint'),
            'index'        => 'endpoint'
        ));

        $this->addColumn('client', array(
            'header'   => $helper->__('Client'),
            'index'    => 'client'
        ));

        $this->addColumn('created_at', array(
            'header'   => $helper->__('Date'),
            'index'    => 'created_at'
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}