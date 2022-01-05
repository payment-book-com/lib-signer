<?php

namespace PaymentBook\Signer;

use Illuminate\Support\Arr;

/**
 * Class Signer
 * @package PaymentBook\Signer
 */
class Signer
{
    const ALGORITHM = 'sha512';
    const ITEMS_DELIMITER = ';';

    /**
     * @param array $request
     * @param string $secretKey
     * @param bool $notHash
     *
     * @return string
     */
    public static function sign(array $request, string $secretKey, bool $notHash = false): string
    {
        $stringToSign = implode(self::ITEMS_DELIMITER, self::getFlattenRequest($request));

        return $notHash
            ? $stringToSign : base64_encode(hash_hmac(self::ALGORITHM, $stringToSign, $secretKey, true));
    }

    /**
     * @param array $request
     *
     * @return array
     */
    private static function getFlattenRequest(array $request): array
    {
        unset($request['general']['signature']);

        $flattenRequest = [];
        foreach (Arr::dot($request) as $key => $value) {
            $flattenRequest[] = $key . ':' . $value;
        }

        return $flattenRequest;
    }
}
