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
        $date = new \DateTime($date);
        $isWorkday = WorkdayDetector::isWorkday($date, $country);

        return [
            'date'    => $date->format('Y-m-d'),
            'country' => $country,
            'isWorkday' => $isWorkday,
        ];
    }

    public function getHoliday($holidayName, $country = 'us'): array
    {
        // Route parameters arrive URL-encoded (e.g. "Thanksgiving%20Day"),
        // while HolidayDetector indexes holidays by their plain names.
        $holidayName = urldecode((string) $holidayName);

        $holidayDetector = new HolidayDetector($country);
        $holiday = null;
        foreach ($this->getHolidayNameCandidates($holidayName) as $candidate) {
            $holiday = $holidayDetector->getHoliday($candidate);
            if ($holiday !== null) {
                break;
            }
        }

        return [
            'holiday' => $holidayName,
            'country' => $country,
            'date'    => $holiday ? $holiday->format('Y-m-d') : null,
        ];
    }

    /**
     * HolidayDetector only performs exact, case-sensitive lookups. Callers
     * commonly ask for "Christmas" or "Thanksgiving" while the holiday data
     * stores the canonical names "Christmas Day" and "Thanksgiving Day", so
     * try the common variants as well.
     *
     * @return string[]
     */
    private function getHolidayNameCandidates(string $holidayName): array
    {
        $name = trim((string) preg_replace('/\s+/', ' ', $holidayName));
        if ($name === '') {
            return [];
        }

        $titleCase = ucwords(strtolower($name));

        $candidates = [
            $name,
            $name . ' Day',
            $name . "'s Day",
            $titleCase,
            $titleCase . ' Day',
            $titleCase . "'s Day",
        ];

        return array_values(array_unique($candidates));
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
