<?php declare(strict_types=1);

namespace PHPExperts\WorkDayPlannerAPI\DTO;

use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property-read string $startDate Date in YYYY-MM-DD format
 * @property-read string $endDate Date in YYYY-MM-DD format
 */
class WorkdayRangeRequest extends SimpleDTO
{
    /** @var string Date in YYYY-MM-DD format */
    protected string $startDate;

    /** @var string Date in YYYY-MM-DD format */
    protected string $endDate;
}
