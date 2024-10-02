<?php

namespace Application\Model\Stores\Factory;

use Application\Model\Interfaces\ModelFactoryInterface;
use Application\Model\Stores\Store;

class StoreModelFactory implements ModelFactoryInterface
{

    protected $_instanceName;

    public function __construct(string $instanceName = Store::class)
    {
        $this->_instanceName = $instanceName;
    }
    public function create(): Store
    {
        return new $this->_instanceName;
    }
}
