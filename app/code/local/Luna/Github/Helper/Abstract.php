<?php

abstract class Luna_Github_Helper_Abstract extends Mage_Core_Helper_Abstract implements Luna_Github_Interfaces_Helper
{

    /**
     * @var array
     */
    protected $apis = [];

    /**
     * @param  string  $name
     * @param  null|array  $args
     * @return false|Mage_Core_Model_Abstract
     */
    public function __call($name, $args = null)
    {
        if (isset($this->apis[$name])) {
            return Mage::getModel($this->apis[$name]);
        } else {
            return false;
        }
    }
}