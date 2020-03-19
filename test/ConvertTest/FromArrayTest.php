<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\MissingDataException;

/**
 * @coversNothing
 */
class FromArrayTest extends BaseTestCase
{
    /**
     * @covers \Convert\FromArray::fromArray
     */
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

    /**
     * @covers \Convert\FromArray::fromArray
     */
    public function testPublicDoesntNeedMakingAccessible()
    {
        $barValue = 'rab_124';
        $data = [
            'bar' => $barValue,
        ];

        $object = SinglePublicObject::fromArray($data);
        $this->assertSame($barValue, $object->getBar());
    }

    /**
     * @covers \Convert\FromArray::fromArray
     */
    public function testMissingKeyFails()
    {
        $data = [
            'foo' => 'foo_123',
            'quux' => 'quux'
        ];

        $this->expectException(MissingDataException::class);
        $this->expectExceptionMessage(
            "Missing key 'bar' for data. Available keys are: foo, quux."
        );

        SinglePublicObject::fromArray($data);
    }
}
