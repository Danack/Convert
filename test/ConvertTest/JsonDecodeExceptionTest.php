<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\JsonDecodeException;

/**
 * @coversNothing
 */
class JsonDecodeExceptionTest extends BaseTestCase
{
    /**
     * @covers \Convert\JsonDecodeException
     */
    public function testCreateUnknownWorks()
    {
        $message = "An weird unknown error occurred.";

        $jsonDecodeException = JsonDecodeException::createUnknown($message);
        $this->assertSame($message, $jsonDecodeException->getMessage());
        $this->assertSame(0, $jsonDecodeException->getCode());
        $this->assertNull($jsonDecodeException->getPrevious());
    }

    /**
     * @covers \Convert\JsonDecodeException
     */
    public function testFromParsingExceptionWorks()
    {
        $invalidJson = '{"foo":"invalid json string';

        $parser = new \Seld\JsonLint\JsonParser();
        $parsingException = $parser->lint($invalidJson);

        if ($parsingException === null) {
            $this->fail("JsonParser failed to give error");
        }

        $exception = JsonDecodeException::fromParsingException($parsingException);

        $expectedMessage = <<< JSON_ERROR
Parse error on line 1:
{"foo":"invalid json string
------^
Invalid string, it appears you forgot to terminate a string, or attempted to write a multiline string which is invalid
JSON_ERROR;

        $this->assertSame(0, $exception->getCode());
        $this->assertSame($expectedMessage, $exception->getMessage());
        $this->assertSame($parsingException, $exception->getPrevious());
    }
}
