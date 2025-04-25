<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Controllers;

use Pecee\Http\Response;
use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\WorkdayDetector;
use PHPExperts\WorkdayPlanner\WorkdayPlanner;

class WorkdayPlannerController
{
    public function isWorkday($date, $country = 'us'): array
    {
         = new \DateTime($date);
         = WorkdayDetector::isWorkday($date, $country);

        return [
            'date'    => $date->format('Y-m-d'),
            'country' => $country,
            'isWorkday' => $isWorkday,
        ];
    }

    public function getHoliday($holidayName, $country = 'us'): array
    {
        $holidayDetector = new HolidayDetector($country);
        $holiday = $holidayDetector->getHoliday($holidayName);

        return [
            'holiday' => $holidayName,
            'country' => $country,
            'date'    => $holiday ? $holiday->format('Y-m-d') : null,
        ];
    }

    public function getWorkdays($startDate, $endDate, $country = 'us'): array
    {
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $planner = new WorkdayPlanner($start, $end, $country);

        return [
            'startDate' => $startDate,
            'endDate'   => $endDate,
            'country'   => $country,
            'workdays'  => $planner->getWorkdays(),
            'count'     => count($planner),
        ];
    }
}
