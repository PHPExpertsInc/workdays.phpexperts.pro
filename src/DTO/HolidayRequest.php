<?php declare(strict_types=1);

namespace PHPExperts\WorkDayPlannerAPI\DTO;

use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property-read string $date Date in YYYY-MM-DD format
 */
class HolidayRequest extends SimpleDTO
{
    /** @var string Date in YYYY-MM-DD format */
    protected string $date;
}