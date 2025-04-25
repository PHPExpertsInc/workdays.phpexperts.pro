<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests\Integration;

use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerTest extends TestCase
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

        $this->assertTrue($response['success']);
        $this->assertIsArray($response['workdays']);
        $this->assertIsInt($response['count']);
    }

    public function testCanCheckHoliday()
    {
        $response = $this->api->get('/api/holidays/2023-01-01/check', ['country' => 'us']);

        $this->assertTrue($response['success']);
        $this->assertIsBool($response['isHoliday']);
        $this->assertEquals('2023-01-01', $response['date']);
        $this->assertEquals('us', $response['country']);
    }
}
