<?php

use PB\Signer;

/**
 * Class SignerTest
 */
class SignerTest extends \PHPUnit\Framework\TestCase
{
    private const
        CASES_TEST_SIGN_STRING = [
            [
                'request' => [
                    'general' => [
                        'payment_id' => 'someId',
                        'service_id' => 1231,
                        'signature' => 'some_generated_signature'
                    ],
                    'payment' => [
                        'amount' => 10000,
                        'currency' => 'EUR',
                        'description' => 'some coool description'
                    ],
                    'card' => [
                        'bin' => 12312312312312,
                        'cardholder' => 'cardholder',
                        'cvv' => 'cvv',
                    ],
                    'issuer' => [
                        'name' => 'name',
                        'surname' => 'surname',
                        'phone' => '23214321312',
                        'mail' => 'somemail@box.box'
                    ]
                ],
                'sign_string' => 'general.payment_id:someId;general.service_id:1231;payment.amount:10000;payment.currency:EUR;payment.description:some coool description;card.bin:12312312312312;card.cardholder:cardholder;card.cvv:cvv;issuer.name:name;issuer.surname:surname;issuer.phone:23214321312;issuer.mail:somemail@box.box',
            ],
        ],
        CASES_TEST_SIGN = [
            [
                'request' => [
                    'general' => [
                        'payment_id' => 'someId',
                        'service_id' => 1231,
                        'signature' => 'some_generated_signature'
                    ],
                    'payment' => [
                        'amount' => 10000,
                        'currency' => 'EUR',
                        'description' => 'some coool description'
                    ],
                    'card' => [
                        'bin' => 12312312312312,
                        'cardholder' => 'cardholder',
                        'cvv' => 'cvv',
                    ],
                    'issuer' => [
                        'name' => 'name',
                        'surname' => 'surname',
                        'phone' => '23214321312',
                        'mail' => 'somemail@box.box'
                    ]
                ],
                'signature' => '12345',
                'sign' => '8BG8EbMz0bJz0LchwYFtWeZxVFAHmy+09FLFHBWlvvclsiBzPRLL9fb8peJZ03PrH5nN5mWTCLNl0QQsfJY89Q==',
            ],
            [
                'request' => [
                    'general' => [
                        'payment_id' => 'someId2',
                        'service_id' => 1231,
                        'signature' => 'some_generated_signature2'
                    ],
                    'payment' => [
                        'amount' => 10000,
                        'currency' => 'USD',
                        'description' => 'some coool description'
                    ],
                    'card' => [
                        'bin' => 12312312312312,
                        'cardholder' => 'cardholder',
                        'cvv' => 'cvv',
                    ],
                    'issuer' => [
                        'name' => 'name2',
                        'surname' => 'surname2',
                        'phone' => '23214321312222',
                        'mail' => 'somemail@box2.box'
                    ]
                ],
                'signature' => '123451!23#.4%..dasrew',
                'sign' => 'MosdCLVVJxGnljrRWhg4IETnukkOdS4Y2I0R5IoSmhfwrbeM2nU1LVg/Werj4kHFvTjRwFN7D6W7dtv4JXQhCA==',
            ],
        ];

    /**
     * @return void
     */
    public function testSignString()
    {
        foreach (self::CASES_TEST_SIGN_STRING as $case) {
            $string = Signer::sign($case['request'], '', true);
            $this->assertEquals($case['sign_string'], $string, 'string to be signed');
        }
    }

    /**
     * @return void
     */
    public function testSign()
    {
        foreach (self::CASES_TEST_SIGN as $case) {
            $sign = Signer::sign($case['request'], $case['signature']);
            $this->assertEquals($case['sign'], $sign, 'signature');
        }
    }
}
