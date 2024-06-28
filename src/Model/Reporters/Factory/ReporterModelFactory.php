<?php

namespace Application\Model\Reporters\Factory;

use Application\Model\Interfaces\ModelFactoryInterface;
use Application\Model\Reporters\Reporter;

class ReporterModelFactory implements ModelFactoryInterface
{

    protected $_instanceName;

    public function __construct(string $instanceName = Reporter::class)
    {
        $this->_instanceName = $instanceName;
    }
    public function create(): Reporter
    {
        return new $this->_instanceName;
    }
}
