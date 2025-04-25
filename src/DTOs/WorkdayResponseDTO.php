<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\DTOs;

use PHPExperts\SimpleDTO\SimpleDTO;
use PHPExperts\SimpleDTO\NestedDTO;

class WorkdayResponseDTO extends SimpleDTO
{
    /** @var string[] */
    public $workdays;

    /** @var int */
    public $count;
}
