<?php

namespace PB;

final class Signer
{
    private const ALGORITHM = 'sha512';

    public static function sign(array $data, string $key): array
    {
        $data['meta']['signature'] = self::hash($data, $key);

        return $data;
    }

    private static function hash(array $data, string $key): string
    {
        unset($data['meta']['signature']);
        self::rksort($data);

        return hash_hmac(self::ALGORITHM, self::serialize($data), $key);
    }

    public static function validate(array $data, string $key): bool
    {
        return isset($data['meta']['signature']) && hash_equals(self::hash($data, $key), $data['meta']['signature']);
    }

    /**
     * Recursively sort array by keys in lexicographical order.
     */
    private static function rksort(array &$array): void
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                self::rksort($value);
            } elseif (is_string($value)) {
                $value = preg_replace('/\s+/', '+', trim($value));
            }
        }
        ksort($array, SORT_STRING);
    }

    /**
     * Custom serialization matching PHP native serialize for basic types.
     * This allows developers in other languages to easily port the algorithm.
     */
    public static function serialize(mixed $data): string
    {
        if (is_array($data)) {
            $result = 'a:' . count($data) . ':{';
            foreach ($data as $key => $value) {
                $result .= self::serialize($key) . self::serialize($value);
            }
            $result .= '}';
            return $result;
        }

        if (is_string($data)) {
            return 's:' . strlen($data) . ':"' . $data . '";';
        }

        if (is_int($data)) {
            return 'i:' . $data . ';';
        }

        if (is_float($data)) {
            // Ensure float formatting is consistent (avoiding locale comma issues if any)
            return 'd:' . str_replace(',', '.', (string)$data) . ';';
        }

        if (is_bool($data)) {
            return 'b:' . ($data ? '1' : '0') . ';';
        }

        if (is_null($data)) {
            return 'N;';
        }

        throw new \InvalidArgumentException('Unsupported data type for serialization: ' . gettype($data) . '. Only basic types (arrays, strings, numbers, booleans, null) are supported for cross-language compatibility.');
    }
}
