<?php

namespace Tests\Feature;
/*use Illuminate\Foundation\Testing\RefreshDatabase;*/
use Tests\TestCase;
use Illuminate\Support\Carbon;

class ExampleTest extends TestCase
{
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testPlanStatusFeature()
    {
        Carbon::setTestNow('2024-04-10 12:00:00');
        $this->assertTrue(true);
        $this->artisan('update:plan-status');
        Carbon::setTestNow();
    }
}
