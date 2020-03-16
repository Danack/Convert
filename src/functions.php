<?php

declare(strict_types = 1);

/**
 * @param $value
 *
 * @return array{string, null}|array{null, mixed}
 */
function convertToValue($value)
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
        if ($value instanceof \DateTime) {
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
            $values[$key] = convertToValue($entry);
        }

        return [
            null,
            $values
        ];
    }

    if (is_object($value) === true) {
        return [
            sprintf(
                "Unsupported type [%s] of class [%s] for toArray.",
                gettype($value),
                get_class($value)
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

function json_decode_safe($json)
{
    if ($json === null) {
        throw new \Exception("Error decoding JSON: cannot decode null.");
    }

    $data = json_decode($json, true);

    if (json_last_error() === JSON_ERROR_NONE) {
        return $data;
    }

    throw new \Exception("Failed to decode json: " . json_last_error_msg());
//    $parser = new \Seld\JsonLint\JsonParser();
//    $parsingException = $parser->lint($json);
//
//    if ($parsingException !== null) {
//        throw $parsingException;
//    }
//
//    if ($data === null) {
//        throw new \Osf\Exception\JsonException("Error decoding JSON: null returned.");
//    }

//    throw new \Osf\Exception\JsonException("Error decoding JSON: " . json_last_error_msg());
}

/**
 * @param $data
 * @param int $options
 * @return string
 * @throws Exception
 */
function json_encode_safe($data, $options = 0): string
{
    $result = json_encode($data, $options);

    if ($result === false) {
        throw new \Exception("Failed to encode data as json: " . json_last_error_msg());
    }

    return $result;
}
