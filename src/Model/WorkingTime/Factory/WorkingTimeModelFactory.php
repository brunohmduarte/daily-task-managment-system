<?php

namespace Application\Model\WorkingTime\Factory;

use Application\Model\Interfaces\ModelFactoryInterface;
use Application\Model\WorkingTime\WorkingTime;

class WorkingTimeModelFactory implements ModelFactoryInterface
{
    /** @var string $_instanceName */
    protected $_instanceName;

    public function __construct(string $instanceName = WorkingTime::class) 
    {
        $this->_instanceName = $instanceName;
    }

    public function create(): WorkingTime 
    {
        return new $this->_instanceName;
    }
}
