<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Controllers;

use Pecee\Http\Response;
use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\WorkdayDetector;
use PHPExperts\WorkdayPlanner\WorkdayPlanner;

class WorkdayPlannerController
{
    public function isWorkday($date, $country = 'us'): string
    {
        $date = new \DateTime($date);
        $isWorkday = WorkdayDetector::isWorkday($date, $country);

        return response()->json([
            'date'    => $date->format('Y-m-d'),
            'country' => $country,
            'isWorkday' => $isWorkday,
        ]);
    }

    public function getHoliday($holidayName, $country = 'us'): string
    {
        $holidayDetector = new HolidayDetector($country);
        $holiday = $holidayDetector->getHoliday($holidayName);

        return response()->json([
            'holiday' => $holidayName,
            'country' => $country,
            'date'    => $holiday ? $holiday->format('Y-m-d') : null,
        ]);
    }

    public function getWorkdays($startDate, $endDate, $country = 'us'): string
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $planner = new WorkdayPlanner($start, $end, $country);

        return response()->json([
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'country'   => $country,
            'workdays'  => $planner->getWorkdays(),
            'count'     => count($planner),
        ]);
    }
}
