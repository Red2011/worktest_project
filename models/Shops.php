<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shops".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $wifi_name
 * @property string $password
 * @property string $token
 * @property string $create_date
 *
 * @property Sensors[] $sensors
 */
class Shops extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'shops';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_date'], 'required'],
            [['create_date'], 'safe'],
            [['name'], 'string', 'max' => 30],
            [['address', 'token'], 'string', 'max' => 50],
            [['wifi_name', 'password'], 'string', 'max' => 20],
            [['token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'name' => 'Название магазина',
            'address' => 'Адрес магазина',
            'wifi_name' => 'Название Wifi сети',
            'password' => 'Пароль от Wifi сети',
            'token' => 'Токен',
            'create_date' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[Sensors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSensors()
    {
        return $this->hasMany(Sensors::class, ['sensor_token' => 'token']);
    }
}