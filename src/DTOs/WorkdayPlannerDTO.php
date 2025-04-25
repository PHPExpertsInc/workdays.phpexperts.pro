<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\DTOs;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\WriteOnce;

/**
 * @property string $startDate  YYYY-MM-DD format
 * @property string $endDate    YYYY-MM-DD format
 * @property string $country    ISO country code
 */
class WorkdayPlannerDTO extends SimpleDTO
{
    use WriteOnce;
}
