<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Tests;

use PHPExperts\WorkdayPlanner\WorkdayPlanner;
use PHPUnit\Framework\TestCase;

class WorkdayPlannerTest extends TestCase
{
    public function testCanCountWorkdays()
    {
        $start = new \DateTime('2023-01-01');
        $end = new \DateTime('2023-01-31');
        $planner = new WorkdayPlanner($start, $end);

        $this->assertGreaterThan(0, count($planner));
    }

    public function testCanGetWorkdays()
    {
        $start = new \DateTime('2023-01-01');
        $end = new \DateTime('2023-01-31');
        $planner = new WorkdayPlanner($start, $end);

        $workdays = $planner->getWorkdays();
        $this->assertIsArray($workdays);
        $this->assertNotEmpty($workdays);
    }
}
