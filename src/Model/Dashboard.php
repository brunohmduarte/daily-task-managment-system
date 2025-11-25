<?php

namespace Application\Model;

use Application\Factory\Factory;
use Application\Model\Ticket;
use CoffeeCode\DataLayer\Connect;

class Dashboard
{
    /**
     * Retrieves an instance of the given class if it exists.
     *
     * @param string $class The class name to instantiate.
     * @return object|null The instance of the class if it exists, null otherwise.
     */
    public function getModel(string $class)
    {
        if (!class_exists($class)) {
            return null;
        }
        return Factory::create($class);
    }

    /**
     * Get ticket statistics in a single optimized query
     * Returns total, resolved, open, and closed ticket counts
     *
     * @return array Array with keys: total, resolved, open, closed
     */
    public function getTicketStats(): array
    {
        /** @var Ticket $ticketModel */
        $ticketModel = $this->getModel(Ticket::class);

        try {
            // Using raw SQL for better performance - single query approach
            $pdo = Connect::getInstance();
            
            $query = "
                SELECT 
                    COUNT(*) AS total,
                    COUNT(CASE WHEN status = 'Resolvido' THEN 1 END) AS resolved,
                    COUNT(CASE WHEN status = 'Fazendo' THEN 1 END) AS open,
                    COUNT(CASE WHEN status = 'Fechado' THEN 1 END) AS closed
                FROM tickets
            ";

            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return [
                'total' => (int)$result['total'],
                'resolved' => (int)$result['resolved'],
                'open' => (int)$result['open'],
                'closed' => (int)$result['closed'],
            ];

        } catch (\Exception $e) {
            // Fallback: return zero counts if error
            return [
                'total' => 0,
                'resolved' => 0,
                'open' => 0,
                'closed' => 0,
            ];
        }
    }
}