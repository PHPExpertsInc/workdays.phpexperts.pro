<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests;

use PHPExperts\WorkdayPlanner\WorkdayDetector;
use PHPUnit\Framework\TestCase;

class WorkdayDetectorTest extends TestCase
{
    public function testCanDetectWorkdays()
    {
        $date = new \DateTime('2023-01-02'); // Monday after New Year's
        $this->assertTrue(WorkdayDetector::isWorkday($date));
    }

    public function testCanDetectNonWorkdays()
    {
        $date = new \DateTime('2023-01-01'); // New Year's Day (Sunday)
        $this->assertFalse(WorkdayDetector::isWorkday($date));
    }
}
