<?php

namespace Application\Model\Tickets;

use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;

class Ticket extends DataLayer 
{
    use SearchTrait;

    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'tickets';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['reference', 'title', 'description', 'status', 'reporter_id', 'priority'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'ticket_id';

    /**
     * Required to create the created_at and updated_at fields 
     * @var boolean $timestamp
     */
    public $timestamp = true;

    /**
     * User constructor
     */
    public function __construct() 
    {
        parent::__construct($this->entity, $this->fieldsAllowed, $this->fieldIdentifier, $this->timestamp);
    }
    
}
