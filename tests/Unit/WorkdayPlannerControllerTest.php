<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests\Unit;

use PHPExperts\WorkdayPlanner\Controllers\WorkdayPlannerController;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerControllerTest extends TestCase
{
    private WorkdayPlannerController $controller;

    protected function setUp(): void
    {
        $this->controller = new WorkdayPlannerController();
    }

    public function testCanCheckIfDateIsWorkday()
    {
        $result = $this->controller->isWorkday('2023-12-25');
        $this->assertFalse($result['isWorkday']);
        
        $result = $this->controller->isWorkday('2023-12-26');
        $this->assertTrue($result['isWorkday']);
    }

    public function testCanGetHolidayDate()
    {
        $result = $this->controller->getHoliday('Christmas');
        $this->assertNotNull($result['date']);
        $this->assertSame('12-25', date('m-d', strtotime($result['date'])));
    }

    public function testCanGetHolidayDateFromUrlEncodedName()
    {
        $result = $this->controller->getHoliday('Thanksgiving%20Day');
        $this->assertEquals('Thanksgiving Day', $result['holiday']);
        $this->assertNotNull($result['date']);

        $result = $this->controller->getHoliday('Thanksgiving Day');
        $this->assertNotNull($result['date']);
    }

    public function testCanGetHolidayDateFromShortName()
    {
        // The holiday data stores "Christmas Day", so "Christmas" must resolve to it.
        $result = $this->controller->getHoliday('Christmas');
        $this->assertNotNull($result['date']);
        $this->assertSame('12-25', date('m-d', strtotime($result['date'])));

        $result = $this->controller->getHoliday('Thanksgiving');
        $this->assertNotNull($result['date']);
        $this->assertSame('Thanksgiving', $result['holiday']);
    }

    public function testCanGetWorkdaysBetweenDates()
    {
        $result = $this->controller->getWorkdays('2023-12-01', '2023-12-31');
        $this->assertGreaterThan(15, $result['count']);
        $this->assertContains('2023-12-26', $result['workdays']);
        $this->assertNotContains('2023-12-25', $result['workdays']);
    }
}
