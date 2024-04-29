<?php

namespace app\controllers;


use app\servers\AppServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use yii\web\Controller;

class AppController extends Controller
{
    static $io_port = 9997;

    /**
     * Start a Web Soket server
     * @return null
     */
    static function setInstance() {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new AppServer()
                )
            ),
            9997
        );
        $server->run();
    }
}