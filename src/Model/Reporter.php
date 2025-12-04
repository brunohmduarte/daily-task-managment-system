<?php

namespace Application\Model;

// use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;

class Reporter extends DataLayer 
{
    // use SearchTrait;

    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'reporters';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['name'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'reporter_id';

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

    /**
     * Returns the total number of reporters.
     *
     * @return int
     */
    public function getReportersTotalNumber(): int
    {
        return $this->find()->count();
    }
}