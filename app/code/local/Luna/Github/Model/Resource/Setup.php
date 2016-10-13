<?php

class Luna_Github_Model_Resource_Setup extends Mage_Core_Model_Resource_Setup
{

    /**
     * Prevent data updates from running before Magento is installed.
     *
     * @return Mage_Core_Model_Resource_Setup|Luna_Github_Model_Resource_Setup
     */
    public function applyDataUpdates()
    {
        return Mage::isInstalled() ? parent::applyDataUpdates() : $this;
    }

    /**
     * Prevent sql updates from running before Magento is installed.
     *
     * @return Mage_Core_Model_Resource_Setup|Luna_Github_Model_Resource_Setup
     */
    public function applyUpdates()
    {
        return Mage::isInstalled() ? parent::applyUpdates() : $this;
    }

}
