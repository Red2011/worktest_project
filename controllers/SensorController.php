<?php

namespace app\controllers;

use Yii;
use app\models\Sensors;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SensorController implements the CRUD actions for Sensors model.
 */
class SensorController extends Controller {

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
     * Lists all Sensors models.
     *
     * @return string
     */
    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Sensors::find(),
                /*
                  'pagination' => [
                  'pageSize' => 50
                  ],
                  'sort' => [
                  'defaultOrder' => [
                  'id' => SORT_DESC,
                  ]
                  ],
                 */
        ]);

        return $this->render('index', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sensors model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    //отображение данных датчиков по id устройства без header
    public function actionViewData($id) {
        $this->setShowHeader(false);
        return $this->render('viewDatas', [
                    'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new Sensors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    //создание нового устройства для магазина с токеном $token без header
    //переделать, т.к. создаётся 1 устройство с 1 датчиком каждый раз
    public function actionCreate($token) {
        $this->setShowHeader(false);
        $model = new Sensors();
        //получение всех id устройств магазина и создание нового id
        $ids = $this->findAllSensors($token);
        sort($ids);
        $last_id = end($ids);

        if ($this->request->isPost) {
            $model->sensor_token = $token;
            $model->sensor_id = $last_id + 1;
            if ($model->mac === null) {
                $model->mac = "0";
            }
            if ($model->load($this->request->post()) && $model->save()) {
                error_log(json_encode($model->attributes));
                return Yii::$app->runAction('shop/view-by-token', ['token' => $token]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Sensors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Sensors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($sensor, $token) {
        $this->findModel($sensor)->delete();

        return Yii::$app->runAction('shop/view-by-token', ['token' => $token]);
    }

    /**
     * Finds the Sensors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Sensors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Sensors::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'Device not found'));
    }

    //получение всех устройств по токену магазина
    protected function findAllSensors($token) {
        $ids = array();
        if (($model = Sensors::findAll(['sensor_token' => $token])) !== null) {
            foreach ($model as $item) {
                $ids[] = $item->sensor_id;
            }
            return $ids;
        } else {
            $ids[] = 1;
            return $ids;
        }
    }
}
