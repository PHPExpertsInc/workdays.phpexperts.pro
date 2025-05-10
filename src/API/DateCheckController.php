<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\API;

use PHPExperts\WorkdayPlanner\WorkdayDetector;
use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\DTOs\DateCheckResponseDTO;

class DateCheckController
{
    public function checkWorkday(string $date, string $country = 'us'): DateCheckResponseDTO
    {
        $isWorkday = WorkdayDetector::isWorkday(new \DateTime($date), $country);

        return new DateCheckResponseDTO([
            'isWorkday' => $isWorkday,
            'date' => $date,
            'country' => $country,
        ]);
    }

    public function checkHoliday(string $date, string $country = 'us'): DateCheckResponseDTO
    {
        $isHoliday = (new HolidayDetector($country))->isHoliday($date);

        return new DateCheckResponseDTO([
            'isHoliday' => $isHoliday,
            'date' => $date,
            'country' => $country,
        ]);
    }
}
