<?php declare(strict_types=1);

/**
 * This file is part of MiniApiBase, a PHP Experts, Inc., Project.
 *
 * Copyright © 2024-2025 PHP Experts, Inc.
 * Author: Theodore R. Smith <theodore@phpexperts.pro>
 *   GPG Fingerprint: 4BF8 2613 1C34 87AC D28F  2AD8 EB24 A91D D612 5690
 *   https://www.phpexperts.pro/
 *   https://github.com/PHPExpertsInc/MiniApiBase
 *
 * This file is licensed under the MIT License.
 */

use Pecee\SimpleRouter\SimpleRouter;
use Pecee\SimpleRouter\SimpleRouter as Router;

SimpleRouter::get('/', function () {
    return <<<HTML
    <!DOCTYPE html>
    <html>
        <head>
            <link rel="stylesheet" href="/css/main.css" />
            <style>
            code { display: block; white-space: pre; font-family: 'Fira Code', monospace; } 
            </style>
        </head>
        <body style="background: #DFDFFF">
            <h1>An API Server created by <a href="https://www.autonomo.codes/">Autonomo by Autonomous Programming, LLC</a>.</h1>
        </body>
    </html>
    HTML;
});
