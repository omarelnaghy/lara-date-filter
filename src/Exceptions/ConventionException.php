<?php

declare(strict_types=1);

namespace OmarElnaghy\LaraDateFilters\Exceptions;

use Exception;

class ConventionException extends Exception
{
    public static function missingDuration(): ConventionException
    {
        return new self('Invalid method call: Duration missing or not in the correct format.');
    }

    public static function missingDateUnit(): ConventionException
    {
        return new self('Invalid method call: Unit missing or not in the correct format');
    }

    public static function invalidDateUnit(): ConventionException
    {
        return new self('Invalid method call: Unit is not a valid date unit.');
    }
}
