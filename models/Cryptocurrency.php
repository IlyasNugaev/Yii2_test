<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cryptocurrency".
 *
 * @property int $id
 * @property string $symbol
 * @property string $name
 * @property string $price_usd
 * @property string|null $updated_at
 */
class Cryptocurrency extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cryptocurrency';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['symbol', 'name', 'price_usd'], 'required'],
            [['price_usd'], 'string'],
            [['updated_at'], 'safe'],
            [['symbol', 'name'], 'string', 'max' => 255],
            [['symbol'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'symbol' => 'Symbol',
            'name' => 'Name',
            'price_usd' => 'Price Usd',
            'updated_at' => 'Updated At',
        ];
    }
}
