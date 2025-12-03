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

    public function init()
    {
        $this->getTicketStats();
        $this->getTicketStatsPercentage();
    }

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

    public function getTicketStatsPercentage()
    {
        /** @var CalculateHelper  $calculateHelper */
        $calculateHelper = Factory::create(CalculateHelper::class);
        
        $resolvedPercentage = $calculateHelper->percentage($this->ticketsResolved, $this->totalTickets);
        $openPercentage     = $calculateHelper->percentage($this->ticketsOpen, $this->totalTickets);
        $closedPercentage   = $calculateHelper->percentage($this->ticketsClosed, $this->totalTickets);

        $this->ticketsResolvedPercentage  = $calculateHelper->percentageFormat($resolvedPercentage);
        $this->ticketsOpenPercentage      = $calculateHelper->percentageFormat($openPercentage);
        $this->ticketsClosedPercentage    = $calculateHelper->percentageFormat($closedPercentage);
    }

    public function getTotalNumberOfTickets()
    {
        return $this->totalTickets;
    }

    public function getTicketsResolved()
    {
        return $this->ticketsResolved;
    }

    public function getTicketsOpen()
    {
        return $this->ticketsOpen;
    }

    public function getTicketsClosed()
    {
        return $this->ticketsClosed;
    }

    public function getTicketsResolvedPercentage()
    {
        return $this->ticketsResolvedPercentage;
    }

    public function getTicketsOpenPercentage()
    {
        return $this->ticketsOpenPercentage;
    }

    public function getTicketsClosedPercentage()
    {
        return $this->ticketsClosedPercentage;
    }
}