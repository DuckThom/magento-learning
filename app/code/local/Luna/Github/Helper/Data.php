<?php

class Luna_Github_Helper_Data extends Luna_Github_Helper_Abstract
{

    /**
     * @var array
     */
    protected $apis = [
        'repositories' => Luna_Github_Model_Api_Repositories::class
    ];

}