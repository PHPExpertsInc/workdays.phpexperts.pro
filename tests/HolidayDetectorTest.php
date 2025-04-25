<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests;

use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPUnit\Framework\TestCase;

class HolidayDetectorTest extends TestCase
{
    public function testCanDetectHolidays()
    {
        $detector = new HolidayDetector();
        $this->assertTrue($detector->isHoliday('2023-12-25')); // Christmas
    }

    public function testCanGetHolidayByName()
    {
        $detector = new HolidayDetector();
        $christmas = $detector->getHoliday('Christmas Day');
        $this->assertInstanceOf(\DateTime::class, $christmas);
    }
}
