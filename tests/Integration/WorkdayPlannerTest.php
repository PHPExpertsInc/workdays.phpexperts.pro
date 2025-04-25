<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests\Integration;

use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerTest extends TestCase
{
    private RESTSpeaker $api;

    protected function setUp(): void
    {
        $this->api = new RESTSpeaker('http://localhost:3000');
    }

    public function testCanCheckIfDateIsWorkday()
    {
        $response = $this->api->get('/api/workday/2023-12-25');
        $this->assertEquals(200, $response->status);
        $this->assertFalse($response->body['isWorkday']);
        
        $response = $this->api->get('/api/workday/2023-12-26');
        $this->assertTrue($response->body['isWorkday']);
    }

    public function testCanGetHolidayDate()
    {
        $response = $this->api->get('/api/holiday/Christmas');
        $this->assertEquals(200, $response->status);
        $this->assertEquals('2023-12-25', $response->body['date']);
    }

    public function testCanGetWorkdaysBetweenDates()
    {
        $response = $this->api->get('/api/workdays/2023-12-01/2023-12-31');
        $this->assertEquals(200, $response->status);
        $this->assertGreaterThan(15, $response->body['count']);
        $this->assertContains('2023-12-26', $response->body['workdays']);
        $this->assertNotContains('2023-12-25', $response->body['workdays']);
    }
}
