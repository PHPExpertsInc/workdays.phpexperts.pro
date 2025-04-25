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
        $this->assertEquals('2023-12-25', $result['date']);
    }

    public function testCanGetWorkdaysBetweenDates()
    {
        $result = $this->controller->getWorkdays('2023-12-01', '2023-12-31');
        $this->assertGreaterThan(15, $result['count']);
        $this->assertContains('2023-12-26', $result['workdays']);
        $this->assertNotContains('2023-12-25', $result['workdays']);
    }
}
