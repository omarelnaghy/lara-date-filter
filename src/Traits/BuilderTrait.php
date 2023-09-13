<?php

namespace OmarElnaghy\LaraDateFilters\Traits;


use Carbon\Carbon;
use OmarElnaghy\LaraDateFilters\Enums\DateRange;

trait BuilderTrait
{
    public function getClassVars()
    {
        return $this->getModel()->dateColumn ?? "created_at";
    }

    public function FilterByDateRange(int $duration, string $dateUnit, Carbon $date, string $direction = 'after', DateRange $range = DateRange::INCLUSIVE)
    {
        $end = clone $date;
        $start = clone $date;

        $addToDateMethod = 'add' . ucfirst($dateUnit) . 's';
        $subFromDateMethod = 'sub' . ucfirst($dateUnit) . 's';

        if ($direction === 'after') {
            $end->$addToDateMethod($duration);
            $date = $range->value === 'exclusive' ? $date->$addToDateMethod(1) : $date;
            $end = $range->value === 'exclusive' ? $end->$subFromDateMethod(1) : $end;
            return $this->whereBetween($this->getClassVars() ?: 'created_at', [$date, $end]);
        }
        if ($direction === 'before') {
            $start->$subFromDateMethod($duration);
            $date = $range->value === 'exclusive' ? $date->$subFromDateMethod(1) : $date;
            $start = $range->value === 'exclusive' ? $start->$subFromDateMethod(1) : $start;
            return $this->whereBetween($this->dateColumn ?: 'created_at', [$start, $date]);
        }

        DateException::invalidValue();
    }

    public function FilterByDateHoursRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'hour', $date, $direction, $range);
    }

    public function FilterByDateMinutesRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'minute', $date, $direction, $range);
    }

    public function FilterByDateSecondsRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'second', $date, $direction, $range);
    }

    public function FilterByDateDaysRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'day', $date, $direction, $range);
    }

    public function FilterByDateWeeksRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'week', $date, $direction, $range);
    }

    public function FilterByDateMonthsRange(int $duration, string $direction, Carbon $date, DateRange $range = DateRange::INCLUSIVE)
    {
        return $this->FilterByDateRange($duration, 'month', $date, $direction, $range);
    }

    public function __call($method, $parameters)
    {
        $matches = [];
        $pattern = '/^(filterByDate)(\d+)([A-Za-z]+)(Range)$/';
        if (preg_match($pattern, $method, $matches)) {
            return $this->filterByDateRange($matches[2], $matches[3], ...$parameters);
        }

        return parent::__call($method, $parameters);
    }
}
