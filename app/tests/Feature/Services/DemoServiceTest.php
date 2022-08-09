<?php

namespace Tests\Feature;

use App\Services\DemoService;
use App\Services\DependentService;
use Tests\TestCase;

class DemoServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $mockedDependant = ($this->getMockBuilder(DependentService::class)
            ->disableOriginalConstructor()
            ->getMock())
            ->method('depDemo')
            ->willReturn(DependentService::class);
        /* @var $demoService DemoService */
        $demoService = $this->app->make(
            DemoService::class,
            [$mockedDependant]
        );
        $this->assertEquals('demoMethod result', $demoService->demoMethod(), "Failed demoMethod");
    }
}
