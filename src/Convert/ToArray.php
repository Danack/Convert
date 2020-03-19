<?php

declare(strict_types = 1);

namespace Convert;

trait ToArray
{
    /**
     * @return array<string, mixed>
     * @throws ConvertFailedException
     */
    public function toArray(): array
    {
        $data = [];
        foreach ($this as $name => $value) {
            if (strpos($name, '_') === 0) {
                // Skip any properties that start with underscore
                continue;
            }

            [$error, $value] = convert_to_value($value);

            if ($error !== null) {
                throw ConvertFailedException::forKey(
                    $name,
                    $error,
                    $this
                );
            }

            $data[$name] = $value;
        }

        return $data;
    }
}
