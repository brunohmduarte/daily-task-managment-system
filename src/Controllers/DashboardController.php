<?php

namespace Application\Controllers;

use Application\Controllers\Controller;
use Application\Factory\Factory;
use Application\Model\Dashboard as DashboardModel;

class DashboardController extends Controller
{
    public $totalTickets;
    public $ticketsResolved;
    public $ticketsOpen;
    public $ticketsClosed;

    public function init()
    {
        $this->getTicketStats();
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
}