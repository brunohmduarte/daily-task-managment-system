<?php

namespace Application\Model\Modules;

use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;

class Module extends DataLayer 
{
    use SearchTrait;

    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'modules';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['name', 'url_repository'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'module_id';

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
    
    public function loadMagentoOneModules() 
    {
        return [];
    }

    public function loadMagentoTwoModules() 
    {
        return [];
    }
}
