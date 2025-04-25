<?php declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\SimpleRouter as Router;
use PHPExperts\WorkdayPlanner\Controllers\WorkdayPlannerController;
use PHPExperts\WorkdayPlanner\Controllers\HolidayController;

SimpleRouter::get('/', function () {
    return <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <title>Workday Planner API</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
                h1 { color: #333; }
                .endpoint { background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
                .method { font-weight: bold; color: #0066cc; }
                .url { font-family: monospace; background: #eee; padding: 2px 5px; }
                .param { margin-left: 20px; }
            </style>
        </head>
        <body>
            <h1>Workday Planner API</h1>
            <p>API Endpoints:</p>
            
            <div class="endpoint">
                <div class="method">GET</div>
                <div class="url">/api/workdays?startDate=YYYY-MM-DD&endDate=YYYY-MM-DD&country=XX</div>
                <p>Returns all workdays between two dates for a given country.</p>
                <div class="param"><strong>Parameters:</strong></div>
                <div class="param">- startDate: Start date in YYYY-MM-DD format (required)</div>
                <div class="param">- endDate: End date in YYYY-MM-DD format (required)</div>
                <div class="param">- country: ISO country code (default: us)</div>
            </div>
            
            <div class="endpoint">
                <div class="method">GET</div>
                <div class="url">/api/holidays/{date}/check?country=XX</div>
                <p>Checks if a given date is a holiday in the specified country.</p>
                <div class="param"><strong>Parameters:</strong></div>
                <div class="param">- date: Date to check in YYYY-MM-DD format (required in URL)</div>
                <div class="param">- country: ISO country code (default: us)</div>
            </div>
        </body>
    </html>
    HTML;
});

SimpleRouter::get('/api/workdays', [WorkdayPlannerController::class, 'getWorkdays']);
SimpleRouter::get('/api/holidays/{date}/check', [HolidayController::class, 'isHoliday']);
