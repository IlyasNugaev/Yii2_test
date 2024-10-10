<?php

namespace app\models;

use yii\base\Model;

class CalculateRequestForm extends Model
{
    public $symbol;
    public $amount;
    public $currency;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['symbol', 'amount', 'currency'], 'required'],
            [['symbol', 'currency'], 'string'],
            [['amount'], 'integer', 'min' => 1],
        ];
    }
}
