<?php declare(strict_types=1);

namespace PHPExperts\WorkdayPlanner\DTOs;

use PHPExperts\SimpleDTO\SimpleDTO;

/**
 * @property string $date
 * @property string $country
 * @property bool   $isWorkday
 */
class WorkdayResponseDTO extends SimpleDTO
{
}
