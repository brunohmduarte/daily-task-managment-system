<?php

namespace Application\Interfaces;

interface CrudInterfaces
{
    public function create();
    public function read();
    public function update();
    public function delete();
}