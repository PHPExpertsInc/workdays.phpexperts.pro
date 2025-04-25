<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

/**
 * @property string $start
 * @property string $end
 * @property string $country
 */
class WorkdayRangeDTO extends SimpleDTO
{
    public function __construct(array $input)
    {
        parent::__construct($input, ['start', 'end', 'country' => 'us']);
    }
}
