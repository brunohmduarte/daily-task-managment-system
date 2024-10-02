<?php

namespace Application;

interface FactoryInterface
{
    public function prepare(string $instance);

    public function create();
}