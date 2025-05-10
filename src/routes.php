<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlannerAPI;

use Pecee\SimpleRouter\SimpleRouter;
use PHPExperts\WorkdayPlanner\WorkdayPlanner;
use PHPExperts\WorkdayPlanner\HolidayDetector;

SimpleRouter::get('/', function () {
    return <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="/css/main.css" />
            <style>
            code { display: block; white-space: pre; font-family: 'Fira Code', monospace; } 
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            tr:nth-child(even) { background-color: #f2f2f2; }
            </style>
        </head>
        <body style="background: #DFDFFF">
            <h1>Workday Planner API</h1>
            
            <h2>Endpoints</h2>
            <table>
                <tr>
                    <th>Endpoint</th>
                    <th>Method</th>
                    <th>Description</th>
                    <th>Parameters</th>
                </tr>
                <tr>
                    <td>/api/workdays</td>
                    <td>GET</td>
                    <td>Get workdays between two dates</td>
                    <td>startDate (YYYY-MM-DD), endDate (YYYY-MM-DD), country (ISO code)</td>
                </tr>
                <tr>
                    <td>/api/holidays</td>
                    <td>GET</td>
                    <td>Get holidays for a specific year</td>
                    <td>year (YYYY), country (ISO code)</td>
                </tr>
                <tr>
                    <td>/api/is-workday</td>
                    <td>GET</td>
                    <td>Check if a date is a workday</td>
                    <td>date (YYYY-MM-DD), country (ISO code)</td>
                </tr>
                <tr>
                    <td>/api/is-holiday</td>
                    <td>GET</td>
                    <td>Check if a date is a holiday</td>
                    <td>date (YYYY-MM-DD), country (ISO code)</td>
                </tr>
            </table>
            
            <h2>Example Requests</h2>
            <code>GET /api/workdays?startDate=2023-01-01&endDate=2023-01-31&country=us</code>
            <code>GET /api/holidays?year=2023&country=us</code>
            <code>GET /api/is-workday?date=2023-01-02&country=us</code>
            <code>GET /api/is-holiday?date=2023-01-01&country=us</code>
        </body>
    </html>
    HTML;
});

SimpleRouter::group(['prefix' => '/api'], function () {
    SimpleRouter::get('/workdays', function () {
        $startDate = input('startDate');
        $endDate = input('endDate');
        $country = input('country', 'us');
        
        if (!$startDate || !$endDate) {
            response()->httpCode(400);
            response()->json(['error' => 'Both startDate and endDate parameters are required']);
            return;
        }
        
        try {
            $planner = new WorkdayPlanner(
                new \DateTime($startDate),
                new \DateTime($endDate),
                $country
            );
            
            response()->json([
                'workdays' => $planner->getWorkdays(),
                'count' => count($planner),
            ]);
        } catch (\Exception $e) {
            response()->httpCode(400);
            response()->json(['error' => $e->getMessage()]);
        }
    });
    
    SimpleRouter::get('/holidays', function () {
        $year = input('year', date('Y'));
        $country = input('country', 'us');
        
        try {
            $detector = new HolidayDetector($country);
            $detector->changeYear((int) $year);
            
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
            
            response()->json([
                'holidays' => $holidays,
                'count' => count($holidays),
            ]);
        } catch (\Exception $e) {
            response()->httpCode(400);
            response()->json(['error' => $e->getMessage()]);
        }
    });
    
    SimpleRouter::get('/is-workday', function () {
        $date = input('date');
        $country = input('country', 'us');
        
        if (!$date) {
            response()->httpCode(400);
            response()->json(['error' => 'date parameter is required']);
            return;
        }
        
        try {
            $isWorkday = WorkdayDetector::isWorkday(new \DateTime($date), $country);
            response()->json([
                'isWorkday' => $isWorkday,
                'date' => $date,
                'country' => $country,
            ]);
        } catch (\Exception $e) {
            response()->httpCode(400);
            response()->json(['error' => $e->getMessage()]);
        }
    });
    
    SimpleRouter::get('/is-holiday', function () {
        $date = input('date');
        $country = input('country', 'us');
        
        if (!$date) {
            response()->httpCode(400);
            response()->json(['error' => 'date parameter is required']);
            return;
        }
        
        try {
            $isHoliday = (new HolidayDetector($country))->isHoliday($date);
            response()->json([
                'isHoliday' => $isHoliday,
                'date' => $date,
                'country' => $country,
            ]);
        } catch (\Exception $e) {
            response()->httpCode(400);
            response()->json(['error' => $e->getMessage()]);
        }
    });
});
