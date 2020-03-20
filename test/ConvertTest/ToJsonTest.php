<?php

declare(strict_types = 1);

namespace ConvertTest;

/**
 * @coversNothing
 */
class ToJsonTest extends BaseTestCase
{
    /**
     * @covers \Convert\ToJson::toJson
     */
    public function testToJsonWorks()
    {
        $fooValue = 123;
        $barValue = 'rab_123';

        $object = new SimpleToJsonObject($fooValue, $barValue);

        $data = [
            'foo' => $fooValue,
            'bar' => $barValue,
        ];

        $this->assertSame(json_encode($data), $object->toJson());
    }
}
