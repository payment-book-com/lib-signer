# PHP SDK - Request Signer & Validator

A lightweight PHP library for generating and validating cryptographic signatures for API requests to the GATE DIRECT API.
This library ensures secure communication by signing your payloads and preventing data tampering.

## Features

- **Signature Generation**: Automatically sorts and flattens payload data to generate a secure HMAC SHA-256 signature.
- **Signature Validation**: Securely verifies incoming requests (e.g., from Webhooks) to ensure they originated from Payment Book.
- **Zero Dependencies**: Lightweight and fast, relying only on native PHP functions.

## Basic Usage

### Signing a Request Payload

```php
use PB\Signer;

$payload = [
    "meta" => [
        "payment_id" => "3322423",
        "service_id" => 1,
    ],
    "payment" => [
        "price" => "12.32",
        "currency" => "EUR"
    ],
    "company" => [
        "name" => "Acme Corp",
        "bank_name" => "Test Bank",
        "bank_account" => "LV33HABA0000000000000",
        "bank_swift" => "HABAXXXX",
        "vat_number" => "LV40000000000",
        "address" => "123 Business Rd."
    ],
    "payer" => [
        "email" => "test@example.com",
        "name" => "John",
        "surname" => "Doe",
        "phone" => "+37123446666",
        "address" => "Some address 255"
    ],
    "order" => [
        [
            "currency" => "EUR",
            "price" => "5.32",
            "textual" => "Order item 1 description"
        ],
        [
            "currency" => "EUR",
            "price" => "7.00",
            "textual" => "Order item 2 description"
        ]
    ]
];

$secretKey = 'YOUR_SERVICE_SECRET_KEY';

// The sign method will automatically compute the signature and inject it into $payload['meta']['signature']
$signedPayload = Signer::sign($payload, $secretKey);
```

> [!IMPORTANT]
> **API HTTP Request**: When making requests to the GATE DIRECT API, you must include the `X-REQUEST-TOKEN-NAME` header containing the name of the API Token used to sign the request.

---
**Powered by [payment-book.com](https://payment-book.com/)**
