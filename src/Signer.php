<?php

namespace PB\Signer;

final class Signer
{
    private const ALGORITHM = 'sha512';

    public static function sign(array $data, string $key): array
    {
        $data['general']['signature'] = self::hash($data, $key);

        return $data;
    }

    private static function hash(array $data, string $key): string
    {
        unset($data['general']['signature']);
        self::rksort($data);

        return hash_hmac(self::ALGORITHM, serialize($data), $key);
    }

    public static function validate(array $data, string $key): bool
    {
        return isset($data['general']['signature']) && hash_equals(self::hash($data, $key), $data['general']['signature']);
    }

    /**
     * Recursively sort array by keys in lexicographical order.
     */
    private static function rksort(array &$array): void
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                self::rksort($value);
            }
        }
        ksort($array, SORT_STRING);
    }
}
