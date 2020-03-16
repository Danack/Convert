<?php

declare(strict_types = 1);

namespace Convert;

trait FromArray
{
    /**
     * @param array<string, mixed> $data
     * @return self
     * @throws MissingDataException
     * @throws \ReflectionException
     */
    public static function fromArray(array $data): self
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $instance = $reflection->newInstanceWithoutConstructor();

        $properties = $reflection->getProperties();

        // Iterate over the properties of the object and set them
        foreach ($properties as $property) {
            $key = $property->name;
            if (array_key_exists($key, $data) === false) {
                throw MissingDataException::forKey($key, $data);
            }

            $originallyPrivate = $property->isPrivate();

            if ($originallyPrivate) {
                $property->setAccessible(true);
                $property->setValue($instance, $data[$key]);
                $property->setAccessible(false);
            }
            else {
                $property->setValue($instance, $data[$key]);
            }
        }

        /** @var $instance self */
        return $instance;
    }
}
