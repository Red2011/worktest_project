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
    //модель для магазинов
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
        //правила по которым происходит создание нового магазина
        return [
            [['create_date'], 'required'],
            [['create_date'], 'safe'],
            [['name', 'address', 'wifi_name', 'password'], 'required'],
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
        //переопределение атрибутов для отображения на клиенте
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
    //получение всех устройств у магазина по внешнему ключу
    public function getSensors()
    {
        return $this->hasMany(Sensors::class, ['sensor_token' => 'token']);
    }
}