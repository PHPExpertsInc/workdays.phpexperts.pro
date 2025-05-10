<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\DTOs;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

class DateCheckResponseDTO extends SimpleDTO
{
    /** @var bool */
    public $isWorkday;

    /** @var bool */
    public $isHoliday;

    /** @var string */
    public $date;

    /** @var string */
    public $country;
}
