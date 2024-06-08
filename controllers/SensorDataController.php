<?php

namespace app\controllers;

use app\models\SensorData;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SensorDataController implements the CRUD actions for SensorData model.
 */
class SensorDataController extends Controller {

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
    public function actions()
    {
	return [
		'error' => [
			'class' => 'yii\web\ErrorAction',
		],
	];
    }

    /**
     * Lists all SensorData models.
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex() {
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
//        $dataProvider = new ActiveDataProvider([
//            'query' => SensorData::find(),
//            /*
//            'pagination' => [
//                'pageSize' => 50
//            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'sensor_id' => SORT_DESC,
//                    'time' => SORT_DESC,
//                ]
//            ],
//            */
//        ]);
//
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Displays a single SensorData model.
     * @param int $sensor_id Sensor ID
     * @param string $time Time
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($sensor_id, $time) {
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
//        return $this->render('view', [
//            'model' => $this->findModel($sensor_id, $time),
//        ]);
    }

    /**
     * Creates a new SensorData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreate() {
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
//        $model = new SensorData();
//
//        if ($this->request->isPost) {
//            if ($model->load($this->request->post()) && $model->save()) {
//                return $this->redirect(['view', 'sensor_id' => $model->sensor_id, 'time' => $model->time]);
//            }
//        } else {
//            $model->loadDefaultValues();
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
    }

    /**
     * Updates an existing SensorData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $sensor_id Sensor ID
     * @param string $time Time
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($sensor_id, $time) {
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
//        $model = $this->findModel($sensor_id, $time);
//
//        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'sensor_id' => $model->sensor_id, 'time' => $model->time]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
    }

    /**
     * Deletes an existing SensorData model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $sensor_id Sensor ID
     * @param string $time Time
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($sensor_id, $time) {
        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
//        $this->findModel($sensor_id, $time)->delete();
//
//        return $this->redirect(['index']);
    }

    /**
     * Finds the SensorData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $sensor_id Sensor ID
     * @param string $time Time
     * @return SensorData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($sensor_id, $time) {
        if (($model = SensorData::findOne(['sensor_id' => $sensor_id, 'time' => $time])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(\Yii::t('app', 'The requested page was not found'));
    }
}
