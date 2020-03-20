<?php

declare(strict_types = 1);

namespace ConvertTest;

/**
 * @coversNothing
 */
class FromJsonTest extends BaseTestCase
{
    /**
     * @covers \Convert\FromJson::fromJson
     */
    public function testToStringWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $object = SimpleFromStringObject::fromJson(json_encode($data));

        $this->assertSame($fooValue, $object->getFoo());
        $this->assertSame($barValue, $object->getBar());
    }
}
