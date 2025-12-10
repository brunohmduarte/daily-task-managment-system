<?php

namespace Application\Model;

// use Application\Model\Resources\SearchTrait;
use CoffeeCode\DataLayer\DataLayer;
use CoffeeCode\DataLayer\Connect;

class Ticket extends DataLayer 
{
    // use SearchTrait;

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

    /**
     * Executes a raw SQL query and returns the result as an array of objects.
     * 
     * @param string $query The raw SQL query to be executed.
     * @return array An array of objects containing the result of the query.
     */
    public function executeQuery(string $query) 
    {
        $stmt = Connect::getInstance()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Returns an array of ticket statistics for the last 12 months.
     * The statistics are grouped by year and month, and contain the total number of tickets created for each period.
     * The result is ordered by year in descending order and month in descending order.
     * 
     * @return array
     */
    public function getAllTimeStatistics() 
    {
        $query = "
            SELECT 
                YEAR(created_at) AS ano,
                MONTH(created_at) AS mes_numero,
                COUNT(*) AS total_tickets
            FROM
                tickets
            WHERE
                created_at >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY
                ano,
                mes_numero
            ORDER BY
                ano DESC,
                mes_numero DESC;
        ";
        
        return $this->executeQuery($query);
    }
}