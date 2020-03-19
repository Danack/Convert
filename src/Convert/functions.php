<?php

declare(strict_types = 1);

namespace Convert;

/**
 * @param mixed $value
 * @return array{string, null}|array{null, mixed}
 */
function convert_to_value($value)
{
    if (is_scalar($value) === true) {
        return [
            null,
            $value
        ];
    }

    if ($value === null) {
        return [
            null,
            null
        ];
    }

    $callable = [$value, 'toArray'];
    if (is_object($value) === true && is_callable($callable)) {
        return [
            null,
            $callable()
        ];
    }

    if (is_object($value) === true) {
        if ($value instanceof \DateTimeInterface) {
            // Format as Atom time with microseconds
            return [
                null,
                $value->format("Y-m-d\TH:i:s.uP")
            ];
        }
    }

    if (is_array($value) === true) {
        $values = [];
        foreach ($value as $key => $entry) {
            [$error, $value] = convert_to_value($entry);
            if ($error !== null) {
                return [$error, null];
            }

            $values[$key] = $value;
        }

        return [
            null,
            $values
        ];
    }

    if (is_object($value) === true) {
        return [
            sprintf(
                "Object of type [%s] does not have toArray method and isn't supported type.",
                gettype($value)
            ),
            null
        ];
    }

    return [
        sprintf(
            "Unsupported type [%s] for toArray.",
            gettype($value)
        ),
        null
    ];
}


/**
 * @param string $json
 * @return mixed
 * @throws \Convert\JsonDecodeException
 */
function json_decode_safe(string $json)
{
    $data = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    }

    $lastError = json_last_error_msg();

    $parser = new \Seld\JsonLint\JsonParser();
    $parsingException = $parser->lint($json);

    if ($parsingException !== null) {
        throw JsonDecodeException::fromParsingException($parsingException);
    }

    // This code should never be reached. They would only happen if there
    // was a bug in Seld\JsonLint\JsonParser
    // @codeCoverageIgnoreStart
    $message = sprintf(
        "Error decoding JSON: %s and jsonlint failed to detect the error",
        $lastError
    );

    throw JsonDecodeException::createUnknown($message);
    // @codeCoverageIgnoreEnd
}


/**
 * @param array<mixed> $data
 * @param int $options
 * @return string
 * @throws JsonEncodeException
 */
function json_encode_safe(array $data, int $options = 0): string
{
    $result = json_encode($data, $options);

    if ($result === false) {
        throw new JsonEncodeException(
            "Failed to encode data as json: " . json_last_error_msg()
        );
    }

    return $result;
}
