<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sensor_data".
 *
 * @property int $sensor_id
 * @property string $time
 * @property int $range
 *
 * @property Sensors $sensor
 */
class SensorData extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sensor_data';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sensor_id', 'time', 'range'], 'required'],
            [['sensor_id', 'range'], 'integer'],
            [['time'], 'safe'],
            [['sensor_id', 'time'], 'unique', 'targetAttribute' => ['sensor_id', 'time']],
            [['sensor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sensors::class, 'targetAttribute' => ['sensor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sensor_id' => 'Sensor ID',
            'time' => 'Time',
            'range' => 'Range',
        ];
    }

    /**
     * Gets query for [[Sensor]].
     *
     * @return \yii\db\ActiveQuery
     */

    //получение id устройства у датчика по внешнему ключу
    public function getSensor()
    {
        return $this->hasOne(Sensors::class, ['id' => 'sensor_id']);
    }
}
