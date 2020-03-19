<?php

declare(strict_types = 1);

namespace Convert;

class ConvertFailedException extends ConvertException
{
    /**
     * @param string $propertyName
     * @param string $error
     * @param object $object
     * @return self
     */

    public static function forKey(string $propertyName, string $error, object $object): self
    {
        $message = sprintf(
            "Convert failed for property name '%s' for object of type '%s'. Error: '%s'.",
            $propertyName,
            get_class($object),
            $error
        );

        return new self($message);
    }
}
