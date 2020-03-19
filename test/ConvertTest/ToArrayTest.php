<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\ConvertFailedException;

/**
 * @coversNothing
 */
class ToArrayTest extends BaseTestCase
{
    /**
     * @covers \Convert\ToArray::toArray
     */
    public function testWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $object = new SimpleToObject($fooValue, $barValue);

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $this->assertSame($data, $object->toArray());
    }

    /**
     * @covers \Convert\ToArray::toArray
     */
    public function testSkipsUnderscoreProperty()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $object = new UnderscorePropertyObject($fooValue, $barValue);

        $data = [
            'bar' => $barValue,
        ];

        $this->assertSame($data, $object->toArray());
    }

    /**
     * @covers \Convert\ToArray::toArray
     */
    public function testObjectFailsConversion()
    {
        $object = new FailsConversion();
        $this->expectException(ConvertFailedException::class);

        // TODO - match property name and error.
        $this->expectErrorMessage('Convert failed for property');

        $object->toArray();
        $this->fail("Conversion failed to throw exception.");
    }
}
