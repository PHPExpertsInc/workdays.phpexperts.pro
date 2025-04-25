<?php declare(strict_types=1);

use Pecee\SimpleRouter\SimpleRouter;
use PHPExperts\WorkdayPlanner\WorkdayPlanner;
use PHPExperts\WorkdayPlanner\HolidayDetector;
use PHPExperts\WorkdayPlanner\WorkdayPlannerDTO;
use PHPExperts\WorkdayPlanner\WorkdayRangeDTO;
use PHPExperts\WorkdayPlanner\HolidayDTO;

SimpleRouter::get('/', function () {
    return <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <title>Workday Planner API</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; max-width: 800px; margin: 0 auto; padding: 20px; }
                h1 { color: #2c3e50; }
                h2 { color: #3498db; margin-top: 30px; }
                code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
                .endpoint { background: #f9f9f9; padding: 15px; border-left: 4px solid #3498db; margin: 20px 0; }
                .method { font-weight: bold; color: #e74c3c; }
            </style>
        </head>
        <body>
            <h1>Workday Planner API Documentation</h1>
            
            <div class="endpoint">
                <h2>GET /api/is-workday</h2>
                <p>Check if a specific date is a workday.</p>
                <p><span class="method">GET</span> Parameters:</p>
                <ul>
                    <li><code>date</code> - Required. Date in YYYY-MM-DD format</li>
                    <li><code>country</code> - Optional. Country code (default: 'us')</li>
                </ul>
                <p>Example: <code>/api/is-workday?date=2023-12-25</code></p>
            </div>

            <div class="endpoint">
                <h2>GET /api/workdays-between</h2>
                <p>Get all workdays between two dates.</p>
                <p><span class="method">GET</span> Parameters:</p>
                <ul>
                    <li><code>start</code> - Required. Start date in YYYY-MM-DD format</li>
                    <li><code>end</code> - Required. End date in YYYY-MM-DD format</li>
                    <li><code>country</code> - Optional. Country code (default: 'us')</li>
                </ul>
                <p>Example: <code>/api/workdays-between?start=2023-12-01&end=2023-12-31</code></p>
            </div>

            <div class="endpoint">
                <h2>GET /api/holidays</h2>
                <p>Get all holidays for a specific year and country.</p>
                <p><span class="method">GET</span> Parameters:</p>
                <ul>
                    <li><code>year</code> - Optional. Year (default: current year)</li>
                    <li><code>country</code> - Optional. Country code (default: 'us')</li>
                </ul>
                <p>Example: <code>/api/holidays?year=2023</code></p>
            </div>
        </body>
    </html>
    HTML;
});

SimpleRouter::get('/api/is-workday', function () {
    try {
        $dto = new WorkdayPlannerDTO(input()->all());
        $dateObj = new DateTime($dto->date);
        $isWorkday = WorkdayDetector::isWorkday($dateObj, $dto->country);
        response()->json(['isWorkday' => $isWorkday, 'date' => $dto->date]);
    } catch (Exception $e) {
        response()->httpCode(400)->json(['error' => $e->getMessage()]);
    }
});

SimpleRouter::get('/api/workdays-between', function () {
    try {
        $dto = new WorkdayRangeDTO(input()->all());
        $startDate = new DateTime($dto->start);
        $endDate = new DateTime($dto->end);
        $planner = new WorkdayPlanner($startDate, $endDate, $dto->country);
        $workdays = $planner->getWorkdays('Y-m-d');
        response()->json([
            'start' => $dto->start,
            'end' => $dto->end,
            'country' => $dto->country,
            'workdays' => $workdays,
            'count' => count($workdays)
        ]);
    } catch (Exception $e) {
        response()->httpCode(400)->json(['error' => $e->getMessage()]);
    }
});

SimpleRouter::get('/api/holidays', function () {
    try {
        $dto = new HolidayDTO(input()->all());
        $detector = new HolidayDetector($dto->country);
        $detector->changeYear($dto->year);
        
        $holidays = [];
        foreach ($detector as $date => $dateObj) {
            $holidays[] = $dateObj->format('Y-m-d');
        }
        
        response()->json([
            'year' => $dto->year,
            'country' => $dto->country,
            'holidays' => $holidays,
            'count' => count($holidays)
        ]);
    } catch (Exception $e) {
        response()->httpCode(400)->json(['error' => $e->getMessage()]);
    }
});
