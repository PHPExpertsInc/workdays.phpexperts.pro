<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\DTOs;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

class HolidayResponseDTO extends SimpleDTO
{
    /** @var array[] */
    public $holidays;

    /** @var int */
    public $count;
}
