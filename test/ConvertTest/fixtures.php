<?php

declare(strict_types = 1);

namespace ConvertTest;

use Convert\FromArray;
use Convert\FromJson;
use Convert\ToArray;
use Convert\ToJson;

class FailsConversion
{
    use ToArray;

    private $nonToArrayValue;

    public function __construct()
    {
        $this->nonToArrayValue = new \StdClass();
    }
}

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

class SimpleToArrayObject
{
    use ToArray;

    private int $foo;

    private string $bar;

    /**
     *
     * @param $foo
     * @param $bar
     */
    public function __construct(int $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}

class SimpleFromJsonObject
{
    use FromJson;

    private int $foo;

    private string $bar;

    /**
     *
     * @param $foo
     * @param $bar
     */
    public function __construct(int $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public function getFoo(): int
    {
        return $this->foo;
    }

    public function getBar(): string
    {
        return $this->bar;
    }
}


class SimpleToJsonObject
{
    use ToJson;

    private int $foo;

    private string $bar;

    /**
     *
     * @param $foo
     * @param $bar
     */
    public function __construct(int $foo, string $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}


class UnderscorePropertyObject
{
    use ToArray;

    private int $__foo;

    private string $bar;

    /**
     *
     * @param $foo
     * @param $bar
     */
    public function __construct($foo, $bar)
    {
        $this->__foo = $foo;
        $this->bar = $bar;
    }
}
