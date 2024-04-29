<?php

namespace App\Dto;

class DateTimezoneResultDto
{
    public string $timezone;
    public string $offsetMinutes;
    public string $currentMonthName;
    public int $febMonthDaysCount;
    public int $currentMonthDaysCount;
}