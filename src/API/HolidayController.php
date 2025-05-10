<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\API;

use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\DTOs\HolidayResponseDTO;

class HolidayController
{
    public function getHolidays(int $year, string $country = 'us'): HolidayResponseDTO
    {
        $detector = new HolidayDetector($country);
        $detector->changeYear($year);

        $holidays = [];
        $reflection = new \ReflectionClass($detector);
        $property = $reflection->getProperty('holidaysByName');
        $property->setAccessible(true);
        $holidaysByName = $property->getValue($detector);

        foreach ($holidaysByName as $name => $date) {
            $holidays[] = [
                'name' => $name,
                'date' => $date->format('Y-m-d'),
            ];
        }

        return new HolidayResponseDTO([
            'holidays' => $holidays,
            'count' => count($holidays),
        ]);
    }
}
