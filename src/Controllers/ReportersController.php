<?php

namespace Application\Controllers;

class ReportersController extends Controller
{
    public function init() 
    {
        $this->setCssExternal('https//cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css');
        $this->setJsExternal('https//cdn.datatables.net/2.3.5/js/dataTables.min.js');
    }

    public function index()
    {
        
    }
}