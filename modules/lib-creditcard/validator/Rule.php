<?php
/**
 * CreditCard
 * @package lib-creditcard
 * @version 0.0.1
 */

namespace LibCreditcard\Validator;

use LibCreditcard\Library\CreditCard;

class Rule
{
    static function creditcard($value, $options, $object, $field, $rules): ?array{
        if(!$value)
            return null;

        $info = CreditCard::info($value);
        if(!$info)
            return ['24.0'];

        if(!is_bool($options)){
            if($options != $info['provider']['id'])
                return ['24.1'];
        }

        return null;
    }
}