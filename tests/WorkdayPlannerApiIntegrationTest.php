<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPExperts\RESTSpeaker\RESTSpeaker;
use PHPExperts\RESTSpeaker\NoAuth;

final class WorkdayPlannerApiIntegrationTest extends TestCase
{
    private RESTSpeaker $api;

    protected function setUp(): void
    {
        $auth = new NoAuth();
        $this->api = new RESTSpeaker($auth, 'http://localhost:3000/');
    }

    public function testWorkdayIsTrueOnWorkday(): void
    {
        $response = $this->api->post('workday', ['date' => '2023-10-04']);
        $this->assertIsObject($response);
        $this->assertObjectHasProperty('date', $response);
        $this->assertObjectHasProperty('isWorkday', $response);
        $this->assertSame('2023-10-04', $response->date);
        $this->assertTrue($response->isWorkday);
    }

    public function testWorkdayIsFalseOnWeekend(): void
    {
        $response = $this->api->post('workday', ['date' => '2023-10-07']);
        $this->assertIsObject($response);
        $this->assertFalse($response->isWorkday);
    }

    public function testWorkdayIsFalseOnHoliday(): void
    {
        $response = $this->api->post('workday', ['date' => '2021-07-04']);
        $this->assertFalse($response->isWorkday);
    }

    public function testWorkdaysRange(): void
    {
        $response = $this->api->post('workdays-range', [
            'startDate' => '2023-10-02',
            'endDate'   => '2023-10-06',
        ]);
        $this->assertIsArray($response);
        $expected = ['2023-10-02', '2023-10-03', '2023-10-04', '2023-10-05', '2023-10-06'];
        $this->assertSame($expected, $response);
    }

    public function testHolidayDetection(): void
    {
        $response = $this->api->post('holiday', ['date' => '2021-07-04']);
        $this->assertIsObject($response);
        $this->assertObjectHasProperty('date', $response);
        $this->assertObjectHasProperty('isHoliday', $response);
        $this->assertSame('2021-07-04', $response->date);
        $this->assertTrue($response->isHoliday);

        $responseObserved = $this->api->post('holiday', ['date' => '2021-07-05']);
        $this->assertTrue($responseObserved->isHoliday);
    }
}
