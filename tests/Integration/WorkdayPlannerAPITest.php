<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests\Integration;

use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerAPITest extends TestCase
{
    private $api;

    protected function setUp(): void
    {
        $this->api = new RESTSpeaker('http://localhost:3000');
    }

    public function testCanGetWorkdays()
    {
        $response = $this->api->get('/api/workdays', [
            'startDate' => '2023-01-01',
            'endDate' => '2023-01-31',
            'country' => 'us',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->body->workdays);
        $this->assertGreaterThan(0, $response->body->count);
    }

    public function testCanGetHolidays()
    {
        $response = $this->api->get('/api/holidays', [
            'year' => '2023',
            'country' => 'us',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertIsArray($response->body->holidays);
        $this->assertGreaterThan(0, $response->body->count);
    }

    public function testCanCheckWorkday()
    {
        $response = $this->api->get('/api/is-workday', [
            'date' => '2023-01-02',
            'country' => 'us',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertIsBool($response->body->isWorkday);
    }

    public function testCanCheckHoliday()
    {
        $response = $this->api->get('/api/is-holiday', [
            'date' => '2023-01-01',
            'country' => 'us',
        ]);

        $this->assertEquals(200, $response->status);
        $this->assertIsBool($response->body->isHoliday);
    }

    public function testReturnsErrorForInvalidDates()
    {
        $response = $this->api->get('/api/workdays', [
            'startDate' => 'invalid',
            'endDate' => 'invalid',
        ]);

        $this->assertEquals(400, $response->status);
        $this->assertStringContainsString('error', json_encode($response->body));
    }
}
