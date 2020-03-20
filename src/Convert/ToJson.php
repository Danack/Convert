<?php

declare(strict_types = 1);

namespace Convert;

trait ToJson
{
    use ToArray;

    public function toJson()
    {
        return json_encode_safe($this->toArray());
    }
}
