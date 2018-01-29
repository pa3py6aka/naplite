<?php

namespace core\forms;


use yii\base\Model;
use yii\web\UploadedFile;

class PhotoReportCreateForm extends Model
{
    public $file;
    public $recipeId;

    public function rules()
    {
        return [
            ['file', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'maxSize' => 1024 * 1024 * 5],
            ['recipeId', 'integer'],
        ];
    }

    public function beforeValidate()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'file' => 'Фотография'
        ];
    }
}