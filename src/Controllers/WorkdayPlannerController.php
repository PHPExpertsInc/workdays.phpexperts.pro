<?php declare(strict_types=1);

namespace PHPExperts\WorkDayPlannerAPI\Controllers;

use PHPExperts\WorkdayPlanner\WorkdayDetector;
use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\WorkdayPlanner as Planner;
use PHPExperts\WorkDayPlannerAPI\DTO\WorkdayRequest;
use PHPExperts\WorkDayPlannerAPI\DTO\HolidayRequest;
use PHPExperts\WorkDayPlannerAPI\DTO\WorkdayRangeRequest;
use DateTime;
use Exception;

class WorkdayPlannerController
{
    public function workday(): void
    {
        $data = input()->all();
        try {
            $dto = new WorkdayRequest($data);
            $date = $dto->date;
            $dt = new DateTime($date);
        } catch (Exception $e) {
            response()->httpCode(400)->json(['error' => 'Invalid date']);
        }

        $isWorkday = WorkdayDetector::isWorkday($dt);

        response()->json(['date' => $date, 'isWorkday' => $isWorkday]);
    }

    public function holiday(): void
    {
        $data = input()->all();
        try {
            $dto = new HolidayRequest($data);
            $date = $dto->date;
        } catch (Exception $e) {
            response()->httpCode(400)->json(['error' => 'Invalid date']);
        }

        $isHoliday = (new HolidayDetector())->isHoliday($date);

        response()->json(['date' => $date, 'isHoliday' => $isHoliday]);
    }

    public function workdaysRange(): void
    {
        $data = input()->all();
        try {
            $dto = new WorkdayRangeRequest($data);
            $start = new DateTime($dto->startDate);
            $end = new DateTime($dto->endDate);
        } catch (Exception $e) {
            response()->httpCode(400)->json(['error' => 'Invalid dates']);
        }

        try {
            $planner = new Planner($start, $end);
        } catch (Exception $e) {
            response()->httpCode(400)->json(['error' => $e->getMessage()]);
        }

        $workdays = $planner->getWorkdays();

        response()->json($workdays);
    }
}
