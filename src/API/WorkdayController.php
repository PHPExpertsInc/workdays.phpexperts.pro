<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\API;

use PHPExperts\WorkdayPlanner\WorkdayPlanner;
use PHPExperts\WorkdayPlanner\DTOs\WorkdayResponseDTO;

class WorkdayController
{
    public function getWorkdays(string $startDate, string $endDate, string $country = 'us'): WorkdayResponseDTO
    {
        $planner = new WorkdayPlanner(
            new \DateTime($startDate),
            new \DateTime($endDate),
            $country
        );

        return new WorkdayResponseDTO([
            'workdays' => $planner->getWorkdays(),
            'count' => count($planner),
        ]);
    }
}
