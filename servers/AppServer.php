<?php

namespace app\servers;

use app\controllers\SensorController;
use app\models\SensorData;
use app\models\Sensors;
use DateTime;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Yii;

class AppServer implements MessageComponentInterface
{
    protected $clients;
    public function __construct()
    {
        $this->clients = new \SplObjectStorage; // Для хранения технической информации об присоединившихся клиентах используется технология SplObjectStorage, встроенная в PHP
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        try {
            $data = json_decode($msg, true);
            $timeData =date('Y-m-d H:i:s', ceil($data['timestamp'] / 1000));
            echo $timeData . "\n";
            foreach ($data['data'] as $sensor) {
                $newSensor = new Sensors();
                $newSensor->sensor_token = $data['token'];
                $newSensor->mac = $data['mac'];
                $newSensor->sensor_id = $sensor['id'];
                $thisId = 0;
                $isExist = Sensors::find()->where(['sensor_id'=> $sensor['id'], 'sensor_token' => $data['token'], 'mac' => $data['mac']])->exists();
                $p = $newSensor->validate();
                $converted_res = $p ? 'true' : 'false';
                $k = $newSensor->getErrors();
//                echo json_encode($k);
//                print_r($newSensor->attributes);
                if (!$isExist && $newSensor->save()) {
                    $thisId = $newSensor->id;
                    $createMessage = 'Устройство с mac: ' . $data['mac'] . " и датчиком " . $sensor['id'] . ' создалось';
                    echo $createMessage . "\n";
                    //$from->send($createMessage);
                    $isExist = true;
                }
                else {
                    $sensot = Sensors::find()->where(['sensor_id'=> $sensor['id'], 'sensor_token' => $data['token'], 'mac' => $data['mac']])->one();
                    $thisId = $sensot->primaryKey;
                }

                if ($isExist) {
                    $newSensorData = new SensorData();
                    $newSensorData->sensor_id = $thisId;
                    $newSensorData->time = $timeData;
                    $newSensorData->range = $sensor['range'];
                    if ($newSensorData->save()){
                        $dataMessage = 'ID: ' . $sensor['id'] . ", Time: " . $timeData . ", Mac: " . $data['mac'] . ", range: " . $sensor['range'];
                        $dataMessageArray = [
                            "time" => $timeData,
                            "mac" => $data['mac'],
                            "id" => $sensor['id'],
                            "range" => $sensor['range']
                        ];

                        echo $dataMessage . "\n";
                        $from->send(json_encode($dataMessageArray));
                    }
                }

            }
        }
        catch (\Exception $e) {
            echo 'Исключение: ' . $e->getMessage();
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}