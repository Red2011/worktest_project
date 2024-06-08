<?php

namespace app\controllers;

use app\models\Shops;
use app\models\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ShopController implements the CRUD actions for Shops model.
 */
class ShopController extends Controller {

    //разрешение на отображение header
    protected $_showHeader = true;

    public function setShowHeader($value) {
        $this->_showHeader = (bool) $value;
        return $this;
    }

    public function getShowHeader() {
        return $this->_showHeader;
    }

    /**
     * @inheritDoc
     */
    public function behaviors() {
        return array_merge(
                parent::behaviors(),
                [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'delete' => ['POST'],
                        ],
                    ],
                ]
        );
    }

    /**
     * Lists all Shops models.
     *
     * @return string
     */
    //отображение всех магазинов
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Shops::find(),
            'pagination' => [
                'pageSize' => 4,
                'forcePageParam' => false,
                'pageSizeParam' => false,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ],
        ]);
        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Shops model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    //отображение одного магазина по id
    public function actionView($id) {
        $shop = $this->findModel($id);
        return $this->render('view', [
                    'shop' => $shop,
        ]);
    }

    //отображение магазина по токену
    public function actionViewByToken($token) {
        $model = $this->findModelByToken($token);

        return $this->redirect(['view',
                    'id' => $model->id,
        ]);
    }

    //получение файла с формы, чтение токена и url и отображение страницы с подключением к вебсокету
    public function actionSend() {
        //модель полученного файла
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->upload()) {
                //чтение файла при успешной загрузке на сервер
                $content = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $model->jsonFile), true);
                $token = $content['token'];
                $url = $content['url'];
                //удаление файла
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $model->jsonFile);
                return $this->render('dataview', ['token' => $token, 'url' => $url]);
            }
        }

        return $this->render('send', ['model' => $model]);
    }

//    public function actionDataview($token, $url)
//    {
//        return $this->render('dataview');
//    }

    /**
     * Creates a new Shops model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    //создание магазина
    public function actionCreate() {
        // $url = 'ws://localhost:' . AppController::$io_port;
        $model = new Shops();

        if ($this->request->isPost) {
//            error_log(date("Y-m-d H:i:s"));
            $token = sha1(uniqid());
            //строго заданы токен и дата
            $model->token = $token;
            $model->create_date = date("Y-m-d H:i:s");
            error_log(json_encode($this->request->post()));
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'shop' => $model,
        ]);
    }

    /**
     * Updates an existing Shops model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //измененение информации о магазине
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'shop' => $model,
        ]);
    }

    /**
     * Deletes an existing Shops model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    //удаление магазина
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //добавление нового устройства для магазина
    public function actionAddSensor($token) {
        return Yii::$app->runAction('sensor/create', ['token' => $token]);
    }

    //удаление устройства
    public function actionDeleteSensor($sensor, $token) {
        return Yii::$app->runAction('sensor/delete', ['sensor' => $sensor, 'token' => $token]);
    }

    //получение датчиков устройства
    public function actionViewDatas($sensors_id) {
        return Yii::$app->runAction('sensor/view-data', ['id' => $sensors_id]);
    }

    //формирование файла и загрузка
    public function actionDownload($token, $name) {
        $url = 'ws://localhost:' . AppController::$io_port;
        $data = [
            'token' => $token,
            'url' => $url
        ];
        $jsonData = json_encode($data);
        //отправка файла через headers
        header("Pragma: public");
        header("Content-Type: application/json; charset=utf-8");
        header("Content-Disposition: attachment; charset=utf-8; filename=\"$name.json\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . strlen($jsonData));
        echo $jsonData;
    }

    /**
     * Finds the Shops model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Shops the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    //получение модели магазина по id
    protected function findModel($id) {
        if (($model = Shops::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'Shop not found'));
    }

    //получение модели магазина по токену
    protected function findModelByToken($token) {
        if (($model = Shops::findOne(['token' => $token])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'Shop not found'));
    }
}
