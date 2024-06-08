<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var string $token */
/** @var string $url */
$this->title = \Yii::t('app', 'Sending data');
$this->params['breadcrumbs'][] = $this->title;
?>
<section class="shop-block">
    <table class="sensors-table" style="margin: 0; width: 100%; max-width: 600px">
        <thead>
            <tr>
                <th><?= \Yii::t('app', 'Time') ?></th>
                <th><?= \Yii::t('app', 'Mac - address') ?></th>
                <th><?= \Yii::t('app', 'ID') ?></th>
                <th><?= \Yii::t('app', 'Value') ?></th>
            </tr>
        </thead>
        <tbody id="messages">
        </tbody>
    </table>
</section>
<script>
    let o = "<?= $this->title ?>";
    //открытие соединения с вебсокетом по данным из файла
    //генерация объекта и отправка в вебсокет
    const send_token = "<?= $token ?>";
    const url = "<?= $url ?>";
    let numbers = [0];
    // let count = Math.floor(Math.random() * 10);
    let count = 2;
    let ws = new WebSocket(url);
    myFunction();

    ws.onmessage = function (e) {
        //добавление в таблицу новых строк, если вебсокет отправил их
        let message = JSON.parse(e.data);
        let newRow = document.createElement('tr');
        let newCellTime = document.createElement('td');
        let newCellMac = document.createElement('td');
        let newCellID = document.createElement('td');
        let newCellValue = document.createElement('td');
        newCellTime.textContent = message.time;
        newCellMac.textContent = message.mac;
        newCellID.textContent = message.id;
        newCellValue.textContent = message.range;
        newRow.appendChild(newCellTime);
        newRow.appendChild(newCellMac);
        newRow.appendChild(newCellID);
        newRow.appendChild(newCellValue);
        newRow.classList.add('new-row');
        document.getElementById('messages').prepend(newRow);
    };
    let intervalId;
    //отправка обхекта каждые 2 секунды на вебсокет
    function myFunction() {
        ws.onopen = function (e) {
            intervalId = setInterval(function () {
                ws.send(JSON.stringify(generateRandomObject()));
            }, 2000);
        };

    }

    function stopFunction() {
        console.log('<?= \Yii::t('app', 'After 10 seconds, it ended') ?>');
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
                range: generateRandom(100)
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
