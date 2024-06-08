<?php

namespace app\controllers;

use app\servers\AppServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use yii\web\Controller;

class AppController extends Controller {

    //контроллер для запуска сервера вебсокета
    static $io_port = 9997;

    /**
     * Start a Web Soket server
     * @return null
     */
    static function setInstance() {
        $server = IoServer::factory(
                        new HttpServer(
                                new WsServer(
                                        //сам вебсокет
                                        new AppServer()
                                )
                        ),
                        AppController::$io_port
        );
        $server->run();
    }
}
