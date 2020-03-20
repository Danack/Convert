<?php

declare(strict_types = 1);

namespace Convert;

trait FromJson
{
    use FromArray;

    /**
     * @param string $string
     * @return self
     * @throws MissingDataException
     * @throws \ReflectionException
     */

    public static function fromJson(string $string):self
    {
        return self::fromArray(json_decode_safe($string));
    }
}
