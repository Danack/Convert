<?php

declare(strict_types = 1);

namespace Convert;

trait ToString
{
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $name => $value) {
            if (strpos($name, '__') === 0) {
                //Skip
                continue;
            }

            [$error, $value] = convert_to_value($value);
            $data[$name] = $value;
        }

        return $data;
    }

    public function toString()
    {
        return json_encode_safe($this->toArray());
    }
}
