## PAYMENT BOOK - SIGNER

##### PHP SDK Request signer and validator mini library

---

Basic usage:
```
use PB\Signer;

$request = [
    "meta" => [
        "payment_id" => "3322423",
        "service_id" => 1,
        "signature" => "any"
    ],
    "payment" => [
        "price" => "12.32",
        "currency" => "EUR"
    ],
    "company" => [
        "name": "",
        "bank_name": "",
        "bank_account": "",
        "bank_swift": "",
        "vat_number": "",
        "address": ""
    ],
    "payer" => [
        "email" => "test@ail.com",
        "name" => "name",
        "surname" => "test",
        "phone" => "+37123446666",
        "address" => "Some address 255"
    ],
    "order" => [
        [
            "currency" => "EUR",
            "price" => "5.32",
            "textual" => "some info about order, free text"
        ],
        [
            "currency" => "EUR",
            "price" => "7.00",
            "textual" => "some info about order, free text"
        ]
    ]
]; 

$secretKey = 'SERVICE_SECRET_KEY';
$request = Signer::sign($request, $secretKey);
```

> [!IMPORTANT]
> **API HTTP Request**: You must include the `X-REQUEST-TOKEN-NAME` header in your request with the name of the API Token used to sign the request.

**Powered by [payment-book.com](https://payment-book.com/)**
