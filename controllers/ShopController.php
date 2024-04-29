<?php

namespace app\controllers;

use app\controllers\AppController;
use app\models\Sensors;
use app\models\Shops;
use app\models\UploadForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * ShopController implements the CRUD actions for Shops model.
 */
class ShopController extends Controller
{
    protected $_showHeader = true;

    public function setShowHeader($value)
    {
        $this->_showHeader = (bool)$value;
        return $this;
    }

    public function getShowHeader()
    {
        return $this->_showHeader;
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
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
    public function actionIndex()
    {
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
    public function actionView($id)
    {
        $shop = $this->findModel($id);
        return $this->render('view', [
            'shop' => $shop,
        ]);
    }

    public function actionViewByToken($token)
    {
        $model = $this->findModelByToken($token);

        return $this->redirect(['view',
            'id' => $model->id,
        ]);
    }

    public function actionSend()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->jsonFile = UploadedFile::getInstance($model, 'jsonFile');
            if ($model->upload()) {
               $content = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $model->jsonFile), true);
               $token = $content['token'];
               $url = $content['url'];
               unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $model->jsonFile);
               return $this->render('dataview', ['token'=>$token, 'url'=>$url]);
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
    public function actionCreate()
    {
        $url = 'ws://localhost:' . AppController::$io_port;
        $model = new Shops();

        if ($this->request->isPost) {
//            error_log(date("Y-m-d H:i:s"));
            $token = sha1(uniqid());
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
    public function actionUpdate($id)
    {
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAddSensor($token)
    {
        return Yii::$app->runAction('sensor/create', ['token' => $token]);
    }

    public function actionDeleteSensor($sensor, $token)
    {
        return Yii::$app->runAction('sensor/delete', ['sensor' => $sensor, 'token' => $token]);
    }

    public function actionViewDatas($sensors_id)
    {
        return Yii::$app->runAction('sensor/view-data', ['id' => $sensors_id]);
    }

    public function actionDownload($token, $name)
    {
        $url = 'ws://localhost:' . AppController::$io_port;
        $filePath = $_SERVER['DOCUMENT_ROOT'] . "/files/" . "{$name}" . ".json";
        $files = glob($_SERVER['DOCUMENT_ROOT'] . '/files/*');
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        $data = [
            'token' => $token,
            'url' => $url
        ];
        $jsonData = json_encode($data);
        $fp = fopen($filePath, "wb");
        if ($fp) {
            fwrite($fp, $jsonData);
            fclose($fp);
        }
        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath)->send();
        } else {
            throw new \yii\web\NotFoundHttpException('Файл не найден');
        }
    }

    /**
     * Finds the Shops model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Shops the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shops::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelByToken($token)
    {
        if (($model = Shops::findOne(['token' => $token])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
