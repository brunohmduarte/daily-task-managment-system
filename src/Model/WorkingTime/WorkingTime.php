<?php

namespace Application\Model\WorkingTime;

use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;

class WorkingTime extends DataLayer 
{
    use SearchTrait;

    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'working_time';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['ticket_id'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'time_id';

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
