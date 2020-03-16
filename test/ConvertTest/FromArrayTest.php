<?php

declare(strict_types = 1);

namespace ConvertTest;

/**
 * @coversNothing
 */
class FromArrayTest extends BaseTestCase
{
    public function testWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $object = SimpleFromObject::fromArray($data);

        $this->assertSame($fooValue, $object->getFoo());
        $this->assertSame($barValue, $object->getBar());
    }
}
