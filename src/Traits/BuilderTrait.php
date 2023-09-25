<?php

declare(strict_types=1);

namespace OmarElnaghy\LaraDateFilters\Traits;

use Carbon\Carbon;
use OmarElnaghy\LaraDateFilters\Enums\DateRange;
use OmarElnaghy\LaraDateFilters\Enums\SearchDirection;
use OmarElnaghy\LaraDateFilters\Exceptions\ConventionException;
use OmarElnaghy\LaraDateFilters\Exceptions\DateException;
use PHPUnit\Exception;

trait BuilderTrait
{
    public array $dateUnits = ['Seconds', 'Minutes', 'Hours', 'Days', 'Weeks', 'Months'];

    public function getClassVars()
    {
        return $this->getModel()->dateColumn ?? 'created_at';
    }

    public function FilterByDateRange(int $duration, string $dateUnit, Carbon $date, SearchDirection $direction = SearchDirection::AFTER, DateRange $range = DateRange::INCLUSIVE)
    {
        $end = clone $date;
        $start = clone $date;

        $addToDateMethod = 'add'.ucfirst($dateUnit);
        $subFromDateMethod = 'sub'.ucfirst($dateUnit);

        if ($direction->value === 'after') {
            $end->$addToDateMethod($duration);
            $date = $range->value === 'exclusive' ? $date->$addToDateMethod(1) : $date;
            $end = $range->value === 'exclusive' ? $end->$subFromDateMethod(1) : $end;

            return $this->whereBetween($this->getClassVars(), [$date, $end]);

        }
        if ($direction->value === 'before') {
            $start->$subFromDateMethod($duration);
            $date = $range->value === 'exclusive' ? $date->$subFromDateMethod(1) : $date;
            $start = $range->value === 'exclusive' ? $start->$subFromDateMethod(1) : $start;

            return $this->whereBetween($this->getClassVars(), [$start, $date]);
        }

        DateException::invalidValue();
    }

    public function FilterByDateHoursRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'hour', $date, $direction, $range);
    }

    public function FilterByDateMinutesRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'minute', $date, $direction, $range);
    }

    public function FilterByDateSecondsRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'second', $date, $direction, $range);
    }

    public function FilterByDateDaysRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'day', $date, $direction, $range);
    }

    public function FilterByDateWeeksRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'week', $date, $direction, $range);
    }

    public function FilterByDateMonthsRange(int $duration, SearchDirection $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'month', $date, $direction, $range);
    }

    /**
     * @throws ConventionException
     */
    public function __call($method, $parameters)
    {
        $matches = [];
        $conventions = config('lara_date_filter.custom_date_filter_convention', []);
        $conventions = array_merge($conventions, ['filterByDate{duration}{unit}Range']);

        if (! empty($conventions)) {
            foreach ($conventions as $convention) {
                $pattern = str_replace(['{duration}', '{unit}'], ['(\d+)', '([A-Za-z]+)'], $convention);
                $patternWithoutNumeric = explode('(\d+)', $pattern);
                $patternWithSlash = $patternWithoutNumeric[0].'/';
                if (preg_match("/^$pattern$/", $method, $matches) || preg_match("/^$patternWithSlash", $method, $matches)) {
                    if (isset($matches[1], $matches[2])) {
                        try {
                            $this->validateConvention($matches[1], $matches[2]);

                            return $this->filterByDateRange($matches[1], $matches[2], ...$parameters);
                        } catch (Exception $exception) {
                            return parent::__call($method, $parameters);
                        }
                    }
                }
            }
        }

        return parent::__call($method, $parameters);
    }

    /**
     * @throws ConventionException
     */
    private function validateConvention($duration, $unit): void
    {
        if (! isset($duration) || ! is_numeric($duration)) {
            throw ConventionException::missingDuration();
        }
        if (! isset($unit) || ! is_numeric($duration)) {
            throw ConventionException::missingDateUnit();
        }

        if (! in_array($unit, $this->dateUnits)) {
            throw ConventionException::invalidDateUnit();
        }
    }
}
