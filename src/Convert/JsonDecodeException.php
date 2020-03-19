<?php

declare(strict_types = 1);

namespace Convert;

use Seld\JsonLint\ParsingException;

class JsonDecodeException extends ConvertException
{
    private function __construct(
        string $message = "",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function createUnknown(string $message): self
    {
        return new self($message);
    }

    public static function fromParsingException(ParsingException $parsingException): self
    {
        $code = intval($parsingException->getCode());

        return new self(
            $parsingException->getMessage(),
            $code,
            $parsingException
        );
    }
}
