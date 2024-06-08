<?php

namespace app\servers;

use app\models\SensorData;
use app\models\Sensors;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class AppServer implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage; // Для хранения технической информации об присоединившихся клиентах используется технология SplObjectStorage, встроенная в PHP
    }

    //действия при установке соединение клиента с вебсокетом
    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        echo \Yii::t('app', 'New connection') . "! ({$conn->resourceId})\n";
    }

    //действия при отправке сообщения клиентом на вебсокет
    public function onMessage(ConnectionInterface $from, $msg) {
        try {
            //получени сообщения и преобразование его в ассоциативный массив
            $data = json_decode($msg, true);
            //преобразование timestamp в нормальный вид даты
            $timeData = date('Y-m-d H:i:s', ceil($data['timestamp'] / 1000));
            echo $timeData . "\n";
            foreach ($data['data'] as $sensor) {
                //создание нового объекта устройсва
                $newSensor = new Sensors();
                $newSensor->sensor_token = $data['token'];
                $newSensor->mac = $data['mac'];
                $newSensor->sensor_id = $sensor['id'];
                $thisId = 0;
                //проверка существования записи в бд
                $isExist = Sensors::find()->where(['sensor_id' => $sensor['id'], 'sensor_token' => $data['token'], 'mac' => $data['mac']])->exists();
                $p = $newSensor->validate();
                $converted_res = $p ? 'true' : 'false';
                $k = $newSensor->getErrors();
//                echo json_encode($k);
//                print_r($newSensor->attributes);
                //запись устройства в бд
                if (!$isExist && $newSensor->save()) {
                    $thisId = $newSensor->id;
                    $createMessage = \Yii::t('app', 'Device with mac: {mac} and the sensor {id} it has been created', [
                                'mac' => $data['mac'],
                                'id' => $sensor['id'],
                    ]);
                    echo $createMessage . "\n";
                    //$from->send($createMessage);
                    $isExist = true;
                }
                //получение id существуюущего устройства
                else {
                    $sensot = Sensors::find()->where(['sensor_id' => $sensor['id'], 'sensor_token' => $data['token'], 'mac' => $data['mac']])->one();
                    $thisId = $sensot->primaryKey;
                }
                //запись в бд данных с датчиков устройства
                if ($isExist) {
                    $newSensorData = new SensorData();
                    $newSensorData->sensor_id = $thisId;
                    $newSensorData->time = $timeData;
                    $newSensorData->range = $sensor['range'];
                    if ($newSensorData->save()) {
                        $dataMessage = 'ID: ' . $sensor['id'] . ", Time: " . $timeData . ", Mac: " . $data['mac'] . ", range: " . $sensor['range'];
                        $dataMessageArray = [
                            "time" => $timeData,
                            "mac" => $data['mac'],
                            "id" => $sensor['id'],
                            "range" => $sensor['range']
                        ];

                        echo $dataMessage . "\n";
                        //отправка сообщения на вебсокет клиенту
                        $from->send(json_encode($dataMessageArray));
                    }
                }
            }
        } catch (\Exception $e) {
            echo \Yii::t('app', 'Exception ') . $e->getMessage();
        }
    }

    //действия при закрытии вебсокета
    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        echo \Yii::t('app', 'Connection {connResourseId} has disconnected', [
            'connResourseId' => $conn->resourceId,
        ]);
    }

    //действия при ошибке
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo \Yii::t('app', 'An error has occurred: {message}', [
            'message' => $e->getMessage(),
        ]) . "\n";
        $conn->close();
    }
}
