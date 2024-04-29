<?php

use app\models\Shops;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $token */
/** @var string $url */

$this->title = 'Отправка данных';
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="shop-block">
    <table class="sensors-table" style="margin: 0; width: 100%; max-width: 600px">
        <thead>
        <tr>
            <th>Время</th>
            <th>Mac-адрес</th>
            <th>ID</th>
            <th>Значение</th>
        </tr>
        </thead>
        <tbody id="messages">
        </tbody>
    </table>
</section>
<script>
    let o = "<?= $this->title  ?>";
    const send_token = "<?= $token ?>";
    const url = "<?= $url ?>";
    let numbers = [0];
    // let count = Math.floor(Math.random() * 10);
    let count = 2;
    let ws = new WebSocket(url);
    myFunction()

    ws.onmessage = function (e) {
        let message = JSON.parse(e.data);

        let newRow = document.createElement('tr');
        let newCellTime = document.createElement('td');
        let newCellMac = document.createElement('td');
        let newCellID = document.createElement('td');
        let newCellValue = document.createElement('td');
        newCellTime.textContent = message.time;
        newCellMac.textContent = message.mac;
        newCellID.textContent = message.id
        newCellValue.textContent = message.range;
        newRow.appendChild(newCellTime);
        newRow.appendChild(newCellMac);
        newRow.appendChild(newCellID);
        newRow.appendChild(newCellValue);
        newRow.classList.add('new-row');
        document.getElementById('messages').prepend(newRow);
    }
    let intervalId;
    function myFunction() {
        ws.onopen = function(e) {
            intervalId = setInterval(function(){
                ws.send(JSON.stringify(generateRandomObject()));
            }, 2000);
        };

    }

    function stopFunction() {
        console.log('Спустя 10 сек завершилось');
        clearInterval(intervalId);
    }

    function generateRandomNumber() {
        let randomNumber;
        do {
            randomNumber = Math.floor(Math.random() * 100);
        } while (numbers.includes(randomNumber));
        numbers.push(randomNumber);
        return randomNumber;
    }


    function generateRandomObject() {
        sensors = [];
        let i = 0;
        if (count === 0) {
            count = 1;
        }
        while (i < count) {
            let data = {
                id: generateRandomNumber(),
                range: generateRandom(100),
            };
            sensors.push(data);
            i++;
        }
        return {
            token: send_token,
            mac: generateMACAddress(),
            timestamp: Date.now(),
            data: sensors
        };
    }

    function generateRandom(maxLimit) {
        let rand = Math.random() * maxLimit;
        rand = Math.floor(rand);
        return rand;
    }

    function generateHexSegment() {
        return Math.floor(Math.random() * 256).toString(16).padStart(2, '0').toUpperCase();
    }

    function generateMACAddress() {
        const segments = [];
        for (let i = 0; i < 6; i++) {
            segments.push(generateHexSegment());
        }
        return segments.join('-');
    }



    // ws.close();
</script>