<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sensors".
 *
 * @property int $id
 * @property int $sensor_id
 * @property string $mac
 * @property string $sensor_token
 *
 * @property SensorData[] $sensorDatas
 * @property Shops $sensorToken
 */
class Sensors extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'sensors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['sensor_id'], 'required'],
            [['sensor_id'], 'integer'],
            [['mac', 'sensor_token'], 'string', 'max' => 50],
//            [['sensor_id', 'mac', 'sensor_token'], 'unique', 'targetAttribute' => ['sensor_id', 'mac', 'sensor_token']],
            [['sensor_token'], 'exist', 'skipOnError' => true, 'targetClass' => Shops::class, 'targetAttribute' => ['sensor_token' => 'token']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'sensor_id' => \Yii::t('app', 'Sensor ID'),
            'mac' => \Yii::t('app', 'Mac - address'),
            'sensor_token' => \Yii::t('app', 'Sensor token'),
        ];
    }

    /**
     * Gets query for [[SensorDatas]].
     *
     * @return \yii\db\ActiveQuery
     */
    //получение всех значений датчиков у устройства по внешнему ключу
    public function getSensorDatas() {
        return $this->hasMany(SensorData::class, ['sensor_id' => 'id']);
    }

    /**
     * Gets query for [[SensorToken]].
     *
     * @return \yii\db\ActiveQuery
     */
    //получение токена магазина для устройства по внешнему ключу
    public function getSensorToken() {
        return $this->hasOne(Shops::class, ['token' => 'sensor_token']);
    }
}
