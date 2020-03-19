<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\MissingDataException;

/**
 * @coversNothing
 */
class MissingDataExceptionTest extends BaseTestCase
{
    /**
     * @covers \Convert\MissingDataException
     */
    public function testWorks()
    {
        $missingKey = 'quux';
        $data = [
            'foo' => 'foo_123',
            'bar' => 'bar_123',
        ];

        $exception = MissingDataException::forKey(
            $missingKey,
            $data
        );

        $this->assertSame(
            "Missing key 'quux' for data. Available keys are: foo, bar.",
            $exception->getMessage()
        );
    }
}
