<?php

namespace Infrastructure\Service\DateTimezone;

use App\Dto\DateTimezoneFormDto;
use App\Dto\DateTimezoneResultDto;
use Infrastructure\Service\DateTimezone\ValueObject\DateTimezoneObject;
use RuntimeException;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class DateTimezoneService
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param DateTimezoneFormDto $data
     * @param int $month
     * @return DateTimezoneResultDto
     */
    public function getDatetimeZoneObject(DateTimezoneFormDto $data, int $month): DateTimezoneResultDto
    {
        try {
            $dateTimezoneObject = new DateTimezoneObject($data->date, $data->timezone);
            $offset = $dateTimezoneObject->getOffsetMinutes();

            return $this->serializer->denormalize(
                [
                    'timezone' => $dateTimezoneObject->getTimezoneName(),
                    'offsetMinutes' => ($offset > 0) ? '+' . $offset : (string) $offset,
                    'currentMonthName' => $dateTimezoneObject->getCurrentMonthName(),
                    'febMonthDaysCount' => $dateTimezoneObject->getMonthDaysCount($month),
                    'currentMonthDaysCount' => $dateTimezoneObject->getCurrentMonthDaysCount(),
                ],
                DateTimezoneResultDto::class
            );
        } catch (Throwable $exception) {
            new RuntimeException('Error on parsing date', $exception->getCode(), $exception);
        }
    }
}