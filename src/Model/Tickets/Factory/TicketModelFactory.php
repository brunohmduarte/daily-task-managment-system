<?php

namespace Application\Model\Tickets\Factory;

use Application\Model\Interfaces\ModelFactoryInterface;
use Application\Model\Tickets\Ticket;

class TicketModelFactory implements ModelFactoryInterface
{

    protected $_instanceName;

    public function __construct(string $instanceName = Ticket::class)
    {
        $this->_instanceName = $instanceName;
    }
    public function create(): Ticket
    {
        return new $this->_instanceName;
    }
    
}
