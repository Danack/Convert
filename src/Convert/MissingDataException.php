<?php

declare(strict_types = 1);

namespace Convert;

class MissingDataException extends ConvertException
{
    public static function forKey(string $missingKey, array $data)
    {
        $keys = array_keys($data);
        $message = sprintf(
            "Missing key '%s' for data. Available keys are: %s.",
            $missingKey,
            implode(", ", $keys)
        );

        return new self($message);
    }
}
