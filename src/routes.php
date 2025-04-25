<?php declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use PHPExperts\WorkdayPlanner\Controllers\WorkdayPlannerController;

SimpleRouter::get('/', function () {
    return <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <title>Workday Planner API</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
                h1 { color: #2c3e50; }
                .endpoint { background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
                .method { font-weight: bold; color: #2980b9; }
                .url { font-family: monospace; background: #eaeaea; padding: 2px 5px; border-radius: 3px; }
                .param { font-family: monospace; color: #c0392b; }
            </style>
        </head>
        <body>
            <h1>Workday Planner API Documentation</h1>
            
            <div class="endpoint">
                <h2>Check if a date is a workday</h2>
                <p><span class="method">GET</span> <span class="url">/api/workday/{date}/{country?}</span></p>
                <p>Parameters:</p>
                <ul>
                    <li><span class="param">date</span> - Date in YYYY-MM-DD format (required)</li>
                    <li><span class="param">country</span> - Country code (default: us)</li>
                </ul>
                <p>Example: <span class="url">/api/workday/2023-12-25</span></p>
            </div>
            
            <div class="endpoint">
                <h2>Get holiday date</h2>
                <p><span class="method">GET</span> <span class="url">/api/holiday/{name}/{country?}</span></p>
                <p>Parameters:</p>
                <ul>
                    <li><span class="param">name</span> - Holiday name (required)</li>
                    <li><span class="param">country</span> - Country code (default: us)</li>
                </ul>
                <p>Example: <span class="url">/api/holiday/Christmas</span></p>
            </div>
            
            <div class="endpoint">
                <h2>Get workdays between dates</h2>
                <p><span class="method">GET</span> <span class="url">/api/workdays/{startDate}/{endDate}/{country?}</span></p>
                <p>Parameters:</p>
                <ul>
                    <li><span class="param">startDate</span> - Start date in YYYY-MM-DD format (required)</li>
                    <li><span class="param">endDate</span> - End date in YYYY-MM-DD format (required)</li>
                    <li><span class="param">country</span> - Country code (default: us)</li>
                </ul>
                <p>Example: <span class="url">/api/workdays/2023-12-01/2023-12-31</span></p>
            </div>
        </body>
    </html>
    HTML;
});

SimpleRouter::get('/api/workday/{date}/{country?}', [WorkdayPlannerController::class, 'isWorkday']);
SimpleRouter::get('/api/holiday/{name}/{country?}', [WorkdayPlannerController::class, 'getHoliday']);
SimpleRouter::get('/api/workdays/{startDate}/{endDate}/{country?}', [WorkdayPlannerController::class, 'getWorkdays']);
