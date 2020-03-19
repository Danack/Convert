<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\ConvertFailedException;

/**
 * @coversNothing
 */
class ConvertFailedExceptionTest extends BaseTestCase
{
    /**
     * @covers \Convert\ConvertFailedException
     */
    public function testWorks()
    {
        $propertyName = 'foo';
        $errorString = 'Fake error';

        $exception = ConvertFailedException::forKey(
            $propertyName,
            $errorString,
            new \StdClass()
        );

        $this->assertSame(
            "Convert failed for property name 'foo' for object of type 'stdClass'. Error: 'Fake error'.",
            $exception->getMessage()
        );
    }
}
