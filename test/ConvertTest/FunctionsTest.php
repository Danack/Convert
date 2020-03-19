<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\ConvertFailedException;

use function Convert\ {
    convert_to_value,
    json_encode_safe,
    json_decode_safe
};

/**
 * @coversNothing
 */
class FunctionsTest extends BaseTestCase
{

    public function providesTestWorks()
    {
        yield [1, 1];
        yield [true, true];
        yield [1.0, 1.0];
        yield ['a_string', 'a_string'];
        yield [null, null];
    }

    /**
     * @covers ::\Convert\convert_to_value
     * @dataProvider providesTestWorks
     */
    public function testWorks($input, $expectedOutput)
    {
        [$error, $actualOutput] = convert_to_value($input);

        $this->assertNull($error);
        $this->assertSame($expectedOutput, $actualOutput);
    }

    public function providesTestDateTimeClasses()
    {
        yield [
            'Y-m-d H:i:s:u',
            '2000-01-01 12:20:35:123456',
            'UTC',
            "2000-01-01T12:20:35.123456+00:00"
        ];

        yield [
            'Y-m-d H:i:s',
            '2000-01-01 12:20:35',
            'UTC',
            "2000-01-01T12:20:35.000000+00:00"
        ];
    }

    /**
     * @dataProvider providesTestDateTimeClasses
     * @covers ::\Convert\convert_to_value
     */
    public function testDateTimeClasses($format, $inputTime, $inputTimezone, $expectedOutput)
    {
        $dateTimeZone = new \DateTimeZone($inputTimezone);

        // Test DateTime
        $date = \DateTime::createFromFormat(
            $format,
            $inputTime,
            $dateTimeZone
        );

        [$error, $value] = convert_to_value($date);
        $this->assertNull($error);
        $this->assertSame($expectedOutput, $value);

        // Test DateTimeImmutable
        $date = \DateTimeImmutable::createFromFormat(
            $format,
            $inputTime,
            $dateTimeZone
        );

        [$error, $value] = convert_to_value($date);
        $this->assertNull($error);
        $this->assertSame($expectedOutput, $value);
    }

    /**
     * @covers ::\Convert\convert_to_value
     */
    public function testObjectWithToArrayWorks()
    {
        $fooValue = 123;
        $barValue = 'foo_123';

        $object = new SimpleToObject($fooValue, $barValue);

        [$error, $value] = convert_to_value($object);
        $this->assertNull($error);

        $expectedValues = [
            'foo' => $fooValue,
            'bar' => $barValue
        ];

        $this->assertSame($expectedValues, $value);
    }


    /**
     * @covers ::\Convert\convert_to_value
     */
    public function testArrayWorks()
    {
        $fooValue = 123;
        $barValue = 'bar_123';

        $inputValues = [

            'foo' => $fooValue,
            'bar' => $barValue,
            'object' => new SimpleToObject($fooValue, $barValue),
        ];

        [$error, $value] = convert_to_value($inputValues);
        $this->assertNull($error);

        $expectedResult = [
            'foo' => $fooValue,
            'bar' => $barValue,
            'object' => [
                'foo' => $fooValue,
                'bar' => $barValue,
            ]
        ];

        $this->assertSame($expectedResult, $value);
    }

    /**
     * @covers ::\Convert\convert_to_value
     */
    public function testArrayFailsCorrectly()
    {
        $fooValue = 123;
        $fileHandle = fopen("php://memory", "r+");
        $inputValues = [

            'foo' => $fooValue,
            'fh' => $fileHandle,

        ];

        [$error, $value] = convert_to_value($inputValues);
        $this->assertNull($value);
        $this->assertSame("Unsupported type [resource] for toArray.", $error);
    }

    /**
     * @covers ::\Convert\convert_to_value
     */
    public function testResourceFails()
    {
        $fileHandle = fopen("php://memory", "r+");

        [$error, $value] = convert_to_value($fileHandle);
        $this->assertNull($value);
        $this->assertSame("Unsupported type [resource] for toArray.", $error);
    }

    /**
     * @covers ::\Convert\convert_to_value
     */
    public function testUnsupportedObjectFails()
    {
        $object = new \StdClass();

        [$error, $value] = convert_to_value($object);
        $this->assertNull($value);
        $this->assertSame("Object of type [object] does not have toArray method and isn't supported type.", $error);
    }

    /**
     * @covers ::\Convert\json_decode_safe
     */
    public function testJsonDecodeSafeWorks()
    {
        $result = json_decode_safe('{"foo":"bar"}');

        $expectedData = [
            'foo' => 'bar'
        ];

        $this->assertSame($expectedData, $result);
    }

    /**
     * @covers ::\Convert\json_decode_safe
     */
    public function testJsonDecodeFailsCorrectly()
    {
        $expectedMessage = <<< JSON_ERROR
Parse error on line 1:
{"foo":"invalid json string
------^
Invalid string, it appears you forgot to terminate a string, or attempted to write a multiline string which is invalid
JSON_ERROR;

        $this->expectExceptionMessage($expectedMessage);
        $this->expectException(\Convert\JsonDecodeException::class);

        json_decode_safe('{"foo":"invalid json string');
    }


    /**
     * @covers ::\Convert\json_encode_safe
     */
    public function testJsonEncodeSafeWorks()
    {
        $data = [
            'foo' => 'bar'
        ];

        $result = json_encode_safe($data);
        $this->assertSame('{"foo":"bar"}', $result);
    }

    /**
     * @covers ::\Convert\json_encode_safe
     */
    public function testJsonEncodeFailsWithNonUtf8()
    {
        $data = [
            // 'Invalid 2 Octet Sequence' from
            // https://stackoverflow.com/questions/1301402/example-invalid-utf8-string
            'foo' => "\xc3\x28"
        ];

        $this->expectException(\Convert\JsonEncodeException::class);
        $this->expectExceptionMessage(
            'Failed to encode data as json'
        );
        json_encode_safe($data);
    }
}
