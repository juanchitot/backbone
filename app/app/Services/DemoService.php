<?php

namespace App\Services;

class DemoService
{
    /**
     * @var DependentService
     */
    private $dependent;
    /**
     * @var bool
     */
    private $constructed;

    public function __construct(DependentService $service)
    {
        $this->constructed = true;
        $this->dependent = $service;
    }

    public function demoMethod(): string
    {
        return $this->dependent->depDemo();
    }
}
