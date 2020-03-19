<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\JsonEncodeException;

/**
 * @coversNothing
 */
class JsonEncodeExceptionTest extends BaseTestCase
{
    /**
     * @covers \Convert\JsonEncodeException
     */
    public function testWorks()
    {
        $message = "This is a test";
        $code = 10;
        $previous = new \Exception("A previous exception.");

        $exception = new JsonEncodeException(
            $message,
            $code,
            $previous
        );

        $this->assertSame($message, $exception->getMessage());
        $this->assertSame($code, $exception->getCode());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
