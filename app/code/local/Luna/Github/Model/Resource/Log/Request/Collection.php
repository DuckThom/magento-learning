<?php

class Luna_Github_Model_Resource_Log_Request_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    protected function _construct()
    {
        $this->_init('luna_github/log_request');
    }

}