<?php

declare(strict_types = 1);

namespace ConvertTest;

/**
 * @coversNothing
 */
class FromStringTest extends BaseTestCase
{
    /**
     * @covers \Convert\FromString::fromString
     */
    public function testToStringWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $object = SimpleFromStringObject::fromString(json_encode($data));

        $this->assertSame($fooValue, $object->getFoo());
        $this->assertSame($barValue, $object->getBar());
    }
}
