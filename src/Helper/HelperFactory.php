<?php

namespace Application\Helper;

use Application\FactoryInterface;

class HelperFactory implements FactoryInterface
{
    protected $_instance;

    public function prepare(string $classname)
    {
        // if ((!empty($classname) && class_exists($classname)) && empty($this->_instance)) {
        //     $this->_instance = $classname;
        // }
        $this->_instance = $classname;
        return $this;
    }

    public function create()
    {
        return new $this->_instance;
    }
}
