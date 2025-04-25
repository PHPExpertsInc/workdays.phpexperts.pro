<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

/**
 * @property int    $year
 * @property string $country
 */
class HolidayDTO extends SimpleDTO
{
    public function __construct(array $input)
    {
        parent::__construct($input, ['year' => (int) date('Y'), 'country' => 'us']);
    }
}
