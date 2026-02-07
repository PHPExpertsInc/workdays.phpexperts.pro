<?php declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use PHPExperts\WorkdayPlanner\Controllers\WorkdayPlannerController;

SimpleRouter::get('/', function () {
    return file_get_contents(__DIR__ . '/views/index.html');
});

SimpleRouter::get('/api/workday/{date}/{country?}', [WorkdayPlannerController::class, 'isWorkday']);
SimpleRouter::get('/api/holiday/{name}/{country?}', [WorkdayPlannerController::class, 'getHoliday']);
SimpleRouter::get('/api/workdays/{startDate}/{endDate}/{country?}', [WorkdayPlannerController::class, 'getWorkdays']);

// API endpoint for volunteer signup
SimpleRouter::post('/api/volunteer-signup', [VolunteerController::class, 'register']);

// Get volunteer stats (for internal use)
SimpleRouter::get('/api/volunteer-stats', [VolunteerController::class, 'getStats']);

// Health check endpoint
SimpleRouter::get('/api/health', function () {
    return [
        'status' => 'healthy',
        'service' => 'Digital Partner Backup',
        'timestamp' => date('c')
    ];
});
