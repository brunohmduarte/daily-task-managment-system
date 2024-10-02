<?php

namespace Application\Model\Modules\Factory;

use Application\Model\Interfaces\ModelFactoryInterface;
use Application\Model\Modules\Module;

class ModuleModelFactory implements ModelFactoryInterface
{

    protected $_instanceName;

    public function __construct(string $instanceName = Module::class)
    {
        $this->_instanceName = $instanceName;
    }
    public function create(): Module
    {
        return new $this->_instanceName;
    }
    
}
