<?php

namespace app\models;

use yii\base\Model;

class GetCryptocurrencyRequestForm extends Model
{
    public $limit;
    public $offset;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['limit', 'offset'], 'integer']
        ];
    }
}
