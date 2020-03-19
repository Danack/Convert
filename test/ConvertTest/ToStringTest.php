<?php

declare(strict_types = 1);

namespace ConvertTest;

/**
 * @coversNothing
 */
class ToStringTest extends BaseTestCase
{
    /**
     * @covers \Convert\ToString::toString
     */
    public function testToStringWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $object = new SimpleToStringObject($fooValue, $barValue);

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $this->assertSame(json_encode($data), $object->toString());
    }
}
