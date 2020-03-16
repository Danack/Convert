<?php

declare(strict_types = 1);

namespace Convert;

trait FromString
{
    use FromArray;

//    public static function fromArray(array $data): self
//    {
//        $reflection = new \ReflectionClass(__CLASS__);
//        $instance = $reflection->newInstanceWithoutConstructor();
//
//        foreach ($instance as $key => &$property) {
//            $property = $data[$key];
//        }
//
//        return $instance;
//    }

    /**
     * @param string $string
     * @return FromString
     * @throws MissingDataException
     * @throws \ReflectionException
     */
    public static function fromString(string $string):self
    {
        return self::fromArray(json_decode_safe($string));
    }
}
