<?php

namespace Infrastructure\Service\DateTimezone\ValueObject;

use DateTimeImmutable;
use DateTimeZone;
use InvalidArgumentException;
use Throwable;

class DateTimezoneObject
{
    private DateTimeImmutable $datetime;

    public function __construct(string $date, string $timezone)
    {
        try {
            $this->datetime = DateTimeImmutable::createFromFormat('Y-m-d', $date)
                ->setTimezone(new DateTimeZone($timezone));
        } catch (Throwable $e) {
            throw new InvalidArgumentException('Invalid date or timezone', $e->getCode(), $e);
        }
    }

    public function getTimezoneName(): string
    {
        return $this->datetime->getTimezone()->getName();
    }

    /**
     * minutes
     *
     * @return int
     */
    public function getOffsetMinutes(): int
    {
        return $this->datetime->getOffset() / (60);
    }

    public function getCurrentMonthName(): string
    {
        return $this->datetime
            ->format('F');
    }

    public function getMonthDaysCount(int $month): int
    {
        $currentMonthDate = $this->getDateByMonth($month);

        return (int) $currentMonthDate
            ->format('t');
    }

    public function getCurrentMonthDaysCount(): int
    {
        return (int) $this->datetime
            ->format('t');
    }

    private function getDateByMonth(int $month): DateTimeImmutable
    {
        $monthStr = str_pad($month, 2, '0', STR_PAD_LEFT);

        return DateTimeImmutable::createFromFormat(
            'Y-m-d',
            $this->datetime->format('Y-' . $monthStr . '-01'),
            $this->datetime->getTimezone()
        );
    }
}