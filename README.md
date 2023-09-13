# Laravel Date Filtering Package

A Laravel package for advanced date filtering and manipulation

Laravel Date Filtering is a package that simplifies date-based filtering for your Laravel Eloquent models. It provides a
set of convenient methods to filter records based on various date and time intervals.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Examples](#examples)
  

## Installation

You can install the package via Composer:

```bash
composer require omar-elnaghy/laradate-filters
```

## Usage

Date Filtering Methods: Use the provided methods like FilterByDateRange, FilterByDateHoursRange,
FilterByDateMinutesRange, etc., to filter records based on your specific criteria.

```bash

use Illuminate\Database\Eloquent\Model;
use OmarElnaghy\LaraDateFilters\Traits\Builder\PackageBuilder;

class YourModel extends Model
{
    public function newEloquentBuilder($query)
    {
        return new PackageBuilder($query);
    }
}
```

## Features

**Date Range Filtering** : You can filter records based on a specified date range, including records created "after"
or "before" a certain date and time.
                                                                                              
 ```php
$startDate = Carbon::parse('2023-9-03');
$range = \OmarElnaghy\LaraDateFilters\Enums\DateRange::INCLUSIVE;
$direction = 'after';                                                                                     
$results = Post::filterByDateRange(2,'day',$startDate, $direction, $range)->get();           
 ```                                                                                         
                                                                                             
**Flexible Time Units** : You can filter records using various time units, such as seconds, minutes, hours, days, weeks,
or months.
                                                                                                   
```php
    $results = Post::filterByDateRange(2,'day',$startDate, $direction, $range)->get();      
    $results = Post::filterByDateRange(2,'week',$startDate, $direction, $range)->get();      
    $results = Post::filterByDateRange(2,'hour',$startDate, $direction, $range)->get();      
```                                                                                         
                                                                                            
**Inclusive or Exclusive Ranges** : You can choose whether the date range should be inclusive or exclusive, allowing you
to fine-tune your query results.

```php
$range = \OmarElnaghy\LaraDateFilters\Enums\DateRange::INCLUSIVE;
$range = \OmarElnaghy\LaraDateFilters\Enums\DateRange::EXCLUSIVE;
```

***The key feature***

The key feature of this trait is its ability to catch and handle dynamic date filtering methods based on a simple naming
convention, making it incredibly convenient and powerful for developers. Here's how you can highlight this feature in a
catchy way:

Dynamic Date Filtering Magic

Unleash the magic of dynamic date filtering with our BuilderTrait! No more writing tedious, repetitive date filtering
methods. With this trait, you can create date filters on the fly by simply following a naming convention.


```php

    $results = Post::filterByDateSecondsRange(2,$startDate, $direction, $range)->get();

    $results = Post::filterByDateMinutesRange(2,$startDate, $direction, $range)->get();

    $results = Post::filterByDateHoursRange(2,$startDate, $direction, $range)->get();

    $results = Post::filterByDateDaysRange(2,$startDate, $direction, $range)->get();

    $results = Post::filterByDateWeeksRange(2,$startDate, $direction, $range)->get();

    $results = Post::filterByDateMonthsRange(2,$startDate, $direction, $range)->get();

```

Effortless Date Filtering

Imagine you want to filter records by date, but you don't want to write separate methods for every possible
duration—seconds, minutes, hours, days, weeks, months, and more. Our BuilderTrait has you covered. Just name your method
following the pattern "filterByDateXRange," and voila! X can be any duration, and the trait will handle the rest.
     
```php
// [Duration] is a number refer to the number of [Date Unit] you want to search in          
return Post::filterByDate(Duration)(Date Unit)Range($startDate, $direction, $range)->get();
```

Convenient and Flexible

Need to filter records for the last 30 minutes? Call filterByDate30MinutesRange(). Want records from the last week? It's
as simple as filterByDate{duration}{unit}Range(). The trait dynamically generates these methods, making your code clean and your
life easier.

## Examples

1 - Filter by Custom duration and date unit (second,minutes,hours,..)

```php
$startDate = Carbon::parse('2023-09-03');
$range = \OmarElnaghy\LaraDateFilters\Enums\DateRange::INCLUSIVE;
$direction = 'after';

return Post::filterByDate5DayRange($startDate, $direction, $range)->get();

return Post::filterByDate6WeekRange($startDate, $direction, $range)->get();

return Post::filterByDate7MonthRange($startDate, $direction, $range)->get();
```

