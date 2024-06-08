<?php

namespace app\models;

use yii\base\Model;

class UploadForm extends Model {
    //модель для полученного json файла от клиента

    /**
     * @var UploadedFile
     */
    public $jsonFile;

    public function rules() {
        return [
            [['jsonFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'json'],
        ];
    }

    public function upload() {
        //проверка на сохранение файла на сервере
        if ($this->validate()) {
            $this->jsonFile->saveAs($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->jsonFile->baseName . '.' . $this->jsonFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
