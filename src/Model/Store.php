<?php

namespace Application\Model;

// use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;

class Store extends DataLayer 
{
    // use SearchTrait;

    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'stores';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['responsible', 'email'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'store_id';

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
     * Retrieves the total number of stores.
     *
     * @return int
     */
    public function getStoresTotalNumber(): int
    {
        return $this->find()->count();
    }
}