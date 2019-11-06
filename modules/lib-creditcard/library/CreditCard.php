<?php
/**
 * CreditCard
 * @package lib-creditcard
 * @version 0.0.1
 * @reff https://github.com/zf1/zend-validate/blob/master/library/Zend/Validate/CreditCard.php
 */

namespace LibCreditcard\Library;


class CreditCard
{

    private static $cards_providers = [
        0 => ['AMERICAN_EXPRESS',   'American Express'],
        1 => ['DINERS_CLUB',        'Diners Club'],
        2 => ['DISCOVER',           'Discover'],
        3 => ['JCB',                'JCB'],
        4 => ['LASER',              'Laser'],
        5 => ['MAESTRO',            'Maestro'],
        6 => ['MASTERCARD',         'Mastercard'],
        7 => ['SOLO',               'Solo'],
        8 => ['UNIONPAY',           'China UnionPay '],
        9 => ['VISA',               'Visa'],

        10 => ['INTER_PAYMENT',     'InterPayment'],
        11 => ['INSTA_PAYMENT',     'InstaPayment'],
        12 => ['DANKORT',           'Dankort']
    ];

    private static $cards_rules = [
    //   +------------------------ Number Length
    //   |  +--------------------- Prefix Length
    //   |  |    +---------------- Value Type ( 1 Single, 2 Array, 3 Range )
    //   |  |    |  +------------- Provider Index ( see property $cards_providers )
    //   |  |    |  |   +--------- Value Query
    //   |  |    |  |   |
        12 => [
            2 => [
                [1, 5, 50],
                [3, 5, [56,69]]
            ]
        ],
        13 => [
            2 => [
                [1, 5, 50],
                [3, 5, [56,69]]
            ],
            1 => [
                [1, 9, 4]
            ]
        ],
        14 => [
            3 => [
                [1, 1, 309],
                [3, 1, [300,305]]
            ],
            2 => [
                [1, 5, 50],
                [2, 1, [36,38]],
                [3, 5, [56,69]]
            ]
        ],
        15 => [
            4 => [
                [2, 3, [2131, 1800]]
            ],
            2 => [
                [1, 5, 50],
                [2, 0, [34,37]],
                [3, 5, [56,69]]
            ],
            1 => [
                [1, 2, 5]
            ]
        ],
        16 => [
            6 => [
                [3, 2, [622126,622925]]
            ],
            4 => [
                [1, 2, 6011],
                [1, 12, 5019],
                [3, 3, [3528, 3589]]
            ],
            3 => [
                [1, 10, 636],
                [2, 11, [637,638,639]],
                [3, 2, [644, 649]]
            ],
            2 => [
                [1, 3, 35],
                [1, 2, 65],
                [1, 8, 62],
                [1, 5, 50],
                [2, 1, [38,39]],
                // [2, 1, [54,55]], // Diners Club United States & Canada ( ignored due to duplicate with mastercard )
                [3, 5, [56,69]],
                [3, 6, [51,55]]
            ],
            1 => [
                [1, 9, 4]
            ]
        ],
        17 => [
            3 => [
                [1, 10, 636]
            ],
            2 => [
                [1, 8, 62],
                [1, 5, 50],
                [3, 5, [56,69]]
            ]
        ],
        18 => [
            3 => [
                [1, 10, 636]
            ],
            2 => [
                [1, 8, 62],
                [1, 5, 50],
                [3, 5, [56,69]]
            ]
        ],
        19 => [
            3 => [
                [1, 10, 636]
            ],
            2 => [
                [1, 8, 62],
                [1, 5, 50],
                [3, 5, [56,69]]
            ],
            1 => [
                [1, 9, 4]
            ]
        ]
    ];

    static function validate(string $number): bool {
        return !!self::info($number);
    }

    static function info(string $number): ?array {
        $number = preg_replace('![^0-9]!', '', $number);
        $length = strlen($number);

        $rules = self::$cards_rules[$length] ?? null;
        if(!$rules)
            return null;

        $provider = null;
        foreach($rules as $plen => $prefixes){
            $num_pref = (int)substr($number, 0, $plen);

            foreach($prefixes as $rule){
                $val_opts = $rule[2];

                if($rule[0] === 1)
                    $val_opts = [$val_opts];
                elseif($rule[0] === 3)
                    $val_opts = range($val_opts[0], $val_opts[1]);
                if(!in_array($num_pref, $val_opts))
                    continue;

                $provider = self::$cards_providers[ $rule[1] ];
                break 2;
            }
        }

        if(!$provider)
            return null;

        $sum = 0;
        $weight = 2;

        for($i = $length - 2; $i >= 0; $i--){
            $digit = $weight * $number[$i];
            $sum+= floor($digit / 10) + $digit % 10;
            $weight = $weight % 2 + 1;
        }

        if((10 - $sum % 10) % 10 != $number[$length-1])
            return null;

        return [
            'provider' => [
                'id'    => $provider[0],
                'label' => $provider[1],
                'logo'  => 'N/A'
            ],
            'number' => $number
        ];
    }
}