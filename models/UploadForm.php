<?php

namespace app\models;

use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $jsonFile;

    public function rules()
    {
        return [
            [['jsonFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'json'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->jsonFile->saveAs($_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $this->jsonFile->baseName . '.' . $this->jsonFile->extension);
            return true;
        } else {
            return false;
        }
    }
}