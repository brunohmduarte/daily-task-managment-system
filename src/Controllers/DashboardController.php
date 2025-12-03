<?php

namespace Application\Controllers;

use Application\Controllers\Controller;
use Application\Factory\Factory;
use Application\Helpers\Calculate as CalculateHelper;
use Application\Model\Dashboard as DashboardModel;

class DashboardController extends Controller
{
    public $totalTickets;
    public $ticketsResolved;
    public $ticketsOpen;
    public $ticketsClosed;
    public $ticketsResolvedPercentage;
    public $ticketsOpenPercentage;
    public $ticketsClosedPercentage;

    /**
     * Initializes the controller by calling the methods setting up ticket statistics.
     *
     * This method is called automatically when the controller is instantiated
     */
    public function init()
    {
        $this->getTicketStats();
        $this->getTicketStatsPercentage();
    }

    /**
     * Retrieves the ticket statistics for the dashboard.
     *
     * This method retrieves the total number of tickets, the number of resolved tickets,
     * the number of open tickets, and the number of closed tickets, and stores them in
     * the respective class properties.
     */
    public function getTicketStats()
    {
        /** @var DashboardModel $model */
        $dashboard = Factory::create(DashboardModel::class);
        
        $data = $dashboard->getTicketStats();

        $this->totalTickets     = $data['total']    ?? 0;
        $this->ticketsResolved  = $data['resolved'] ?? 0;
        $this->ticketsOpen      = $data['open']     ?? 0;
        $this->ticketsClosed    = $data['closed']   ?? 0;
    }

    /**
     * Calculates the percentage of each ticket status type compared to the total number of tickets.
     *
     * This method uses the CalculateHelper to calculate the percentage of each ticket status type.
     * The percentages are then formatted to two decimal places and stored in the respective class properties:
     * - $this->ticketsResolvedPercentage
     * - $this->ticketsOpenPercentage
     * - $this->ticketsClosedPercentage
     */
    public function getTicketStatsPercentage()
    {
        /** @var CalculateHelper  $helper */
        $helper = Factory::create(CalculateHelper::class);
        
        $resolvedPercentage = $helper->percentage($this->ticketsResolved, $this->totalTickets);
        $openPercentage     = $helper->percentage($this->ticketsOpen, $this->totalTickets);
        $closedPercentage   = $helper->percentage($this->ticketsClosed, $this->totalTickets);

        $this->ticketsResolvedPercentage  = $helper->percentageFormat($resolvedPercentage);
        $this->ticketsOpenPercentage      = $helper->percentageFormat($openPercentage);
        $this->ticketsClosedPercentage    = $helper->percentageFormat($closedPercentage);
    }

    /**
     * Returns the total number of tickets.
     *
     * @return int
     */
    public function getTotalNumberOfTickets()
    {
        return $this->totalTickets;
    }

    /**
     * Returns the total number of resolved tickets.
     *
     * @return int
     */
    public function getTicketsResolved()
    {
        return $this->ticketsResolved;
    }
    /**
     * Returns the total number of open tickets.
     *
     * @return int
     */
    public function getTicketsOpen()
    {
        return $this->ticketsOpen;
    }
    /**
     * Returns the total number of closed tickets.
     *
     * @return int
     */
    public function getTicketsClosed()
    {
        return $this->ticketsClosed;
    }
    /**
     * Returns the percentage of resolved tickets.
     *
     * @return string
     */
    public function getTicketsResolvedPercentage()
    {
        return $this->ticketsResolvedPercentage;
    }
    /**
     * Returns the percentage of open tickets.
     *
     * @return string
     */
    public function getTicketsOpenPercentage()
    {
        return $this->ticketsOpenPercentage;
    }
    /**
     * Returns the percentage of closed tickets.
     *
     * @return string
     */
    public function getTicketsClosedPercentage()
    {
        return $this->ticketsClosedPercentage;
    }
    
}