<?php

namespace OmarElnaghy\LaraDateFilters\Exceptions;

use Exception;


class DateException extends Exception
{
    public static function invalidValue(): DateException
    {
        return new self('The $value parameter must be a positive integer.');
    }
}

