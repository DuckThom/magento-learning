<?php

interface Luna_Github_Interfaces_Helper
{

    /**
     * @param  string  $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, $arguments);

}