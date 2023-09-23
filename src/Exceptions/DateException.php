<?php

namespace OmarElnaghy\LaraDateFilters\Exceptions;

class DateException extends LaraDateFiltersException
{
    public static function invalidValue(): DateException
    {
        return new self('The $value parameter must be a positive integer.');
    }
}

