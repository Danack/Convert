<?php

declare(strict_types = 1);

namespace Convert;

class MissingDataException extends ConvertException
{
    private function __construct(
        string $message = "",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $missingKey
     * @param array<string> $data
     * @return self
     */
    public static function forKey(string $missingKey, array $data): self
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
