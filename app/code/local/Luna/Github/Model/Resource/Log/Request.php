<?php

class Luna_Github_Model_Resource_Log_Request extends Mage_Core_Model_Resource_Db_Abstract
{

    protected function _construct()
    {
        $this->_init('luna_github/log_request', 'log_request_id');
    }

}