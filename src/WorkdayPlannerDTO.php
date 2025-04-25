<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

/**
 * @property string $date
 * @property string $country
 */
class WorkdayPlannerDTO extends SimpleDTO
{
    public function __construct(array $input)
    {
        parent::__construct($input, ['date', 'country' => 'us']);
    }
}
