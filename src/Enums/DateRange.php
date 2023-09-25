<?php

declare(strict_types=1);

namespace OmarElnaghy\LaraDateFilters\Enums;

enum DateRange: string
{
    case INCLUSIVE = 'inclusive';
    case EXCLUSIVE = 'exclusive';
}
