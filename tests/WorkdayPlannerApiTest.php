<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests;

use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerApiTest extends TestCase
{
    private RESTSpeaker $api;

    protected function setUp(): void
    {
        $this->api = new RESTSpeaker('http://localhost:3000');
    }

    public function testCanCheckIfDateIsWorkday()
    {
        $response = $this->api->get('/api/is-workday', ['date' => '2023-12-25']);
        $this->assertEquals(200, $response->status);
        $this->assertFalse($response->body['isWorkday']);

        $response = $this->api->get('/api/is-workday', ['date' => '2023-12-26']);
        $this->assertEquals(200, $response->status);
        $this->assertTrue($response->body['isWorkday']);
    }

    public function testCanGetWorkdaysBetweenDates()
    {
        $response = $this->api->get('/api/workdays-between', [
            'start' => '2023-12-01',
            'end' => '2023-12-31'
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertGreaterThan(0, $response->body['count']);
        $this->assertIsArray($response->body['workdays']);
        $this->assertNotContains('2023-12-25', $response->body['workdays']);
    }

    public function testCanGetHolidaysForYear()
    {
        $response = $this->api->get('/api/holidays', ['year' => 2023]);
        
        $this->assertEquals(200, $response->status);
        $this->assertGreaterThan(0, $response->body['count']);
        $this->assertIsArray($response->body['holidays']);
        $this->assertContains('2023-12-25', $response->body['holidays']);
    }

    public function testReturnsErrorForInvalidDates()
    {
        $response = $this->api->get('/api/is-workday');
        $this->assertEquals(400, $response->status);
        $this->assertStringContainsString('Date parameter is required', $response->body['error']);

        $response = $this->api->get('/api/workdays-between');
        $this->assertEquals(400, $response->status);
        $this->assertStringContainsString('Both start and end dates are required', $response->body['error']);
    }
}
