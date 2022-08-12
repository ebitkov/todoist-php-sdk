<?php

namespace ebitkov\TodoistSDK\API;

use JMS\Serializer\Annotation as Serializer;

class Due
{
    /**
     * @Serializer\Type("string")
     */
    private string $date;

    /**
     * @Serializer\Type("boolean")
     */
    private bool $isRecurring;

    /**
     * @Serializer\Type("DateTime")
     */
    private \DateTimeInterface $datetime;

    /**
     * @Serializer\Type("string")
     */
    private string $string;

    /**
     * @Serializer\Type("string")
     */
    private string $timezone;
}