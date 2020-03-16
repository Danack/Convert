<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\FromArray;
use Convert\ToArray;

class SimpleFromObject
{
    use FromArray;

    private int $foo;

    private string $bar;

    public function getFoo(): int
    {
        return $this->foo;
    }

    public function getBar(): string
    {
        return $this->bar;
    }
}


class SinglePublicObject
{
    use FromArray;

    public string $bar;

    /**
     * @return string
     */
    public function getBar(): string
    {
        return $this->bar;
    }
}

class SimpleToObject
{
    use FromArray;

    private int $foo;

    private string $bar;

    /**
     *
     * @param $foo
     * @param $bar
     */
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
