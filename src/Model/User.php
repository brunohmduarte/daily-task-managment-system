<?php

namespace Application\Model;

use CoffeeCode\DataLayer\DataLayer;

class User extends DataLayer 
{
    /**
     * Entity name in database
     * @var string $entity
     */
    public $entity = 'users';

    /**
     * List of required fields in the database
     * @var array $fieldsAllowed
     */
    public $fieldsAllowed = ['name', 'email', 'active'];

    /**
     * Identifier field in the User table
     * @var string $fieldIdentifier
     */
    public $fieldIdentifier = 'user_id';

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
     * Checks if a user with the given email exists in the database
     *
     * @param string $email The email to be searched for
     * @return bool True if the user exists, false otherwise
     */
    public function emailExists(string $email): bool
    {
        $user = $this->find("email = :email", "email={$email}")->fetch();
        return $user ? true : false;
    }
}