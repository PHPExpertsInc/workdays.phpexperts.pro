<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Controllers;

use Pecee\Http\Response;
use PHPExperts\WorkdayPlanner\HolidayDetector;

class HolidayController
{
    public function isHoliday(string $date, string $country = 'us'): void
    {
        $isHoliday = (new HolidayDetector($country))->isHoliday($date);
        
        response()->json([
            'success' => true,
            'isHoliday' => $isHoliday,
            'date' => $date,
            'country' => $country,
        ]);
    }
}
