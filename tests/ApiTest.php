<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests;

use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private $api;

    protected function setUp(): void
    {
        $this->api = new RESTSpeaker('http://localhost:3000');
    }

    public function testCanCheckWorkday()
    {
        $response = $this->api->get('/api/is-workday', ['date' => '2023-01-02']);
        $this->assertEquals(200, $response->statusCode);
        $this->assertTrue($response->isWorkday);
    }

    public function testCanGetWorkdaysBetweenDates()
    {
        $response = $this->api->get('/api/workdays-between', [
            'start' => '2023-01-01',
            'end'   => '2023-01-31',
        ]);
        $this->assertEquals(200, $response->statusCode);
        $this->assertIsArray($response->workdays);
    }

    public function testCanGetHolidays()
    {
        $response = $this->api->get('/api/holidays', ['year' => 2023]);
        $this->assertEquals(200, $response->statusCode);
        $this->assertIsArray($response->holidays);
    }
}
