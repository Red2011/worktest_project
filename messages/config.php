<?php

return [
    'color' => null,
    'interactive' => true,
    'help' => false,
    'silentExitOnException' => null,
    'sourcePath' => '@app',
    'messagePath' => '@app/messages',
    'languages' => ['ru-RU'],
    'translator' => [
        'Yii::t',
        '\\Yii::t',
    ],
    'sort' => false,
    'overwrite' => true,
    'removeUnused' => false,
    'markUnused' => true,
    'except' => [
        '.*',
        '/.*',
        '/messages',
        '/tests',
        '/runtime',
        '/vendor',
        '/BaseYii.php',
    ],
    'only' => [
        '*.php',
    ],
    'format' => 'php',
];

