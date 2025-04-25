<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\Controllers;

use Pecee\Http\Response;
use PHPExperts\WorkdayPlanner\DTOs\WorkdayPlannerDTO;
use PHPExperts\WorkdayPlanner\WorkdayPlanner;

class WorkdayPlannerController
{
    public function getWorkdays(): void
    {
        $input = new WorkdayPlannerDTO(input()->all());
        
        $startDate = new \DateTime($input->startDate);
        $endDate = new \DateTime($input->endDate);
        
        $planner = new WorkdayPlanner($startDate, $endDate, $input->country);
        
        response()->json([
            'success' => true,
            'workdays' => $planner->getWorkdays(),
            'count' => count($planner),
        ]);
    }
}
