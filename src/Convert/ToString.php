<?php

declare(strict_types = 1);

namespace Convert;

trait ToString
{
    use ToArray;

    public function toString()
    {
        return json_encode_safe($this->toArray());
    }
}
