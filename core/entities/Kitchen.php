<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%kitchens}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image [varchar(40)]
 */
class Kitchen extends ActiveRecord
{
    public $imageUpload;

    public function getPhotoUrl($forCP = false)
    {
        return ($forCP ? \Yii::$app->params['frontendHostInfo']: '') . '/uploads/ktch/' . $this->image;
    }

    public function saveImage(UploadedFile $image): void
    {
        $name = $this->id . '_' . time() . '.' . $image->extension;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 860, 560);
            if ($this->image && $this->image != $name) {
                $this->removeImages();
            }
            $this->image = $name;
        }
    }

    private function removeImages(): void
    {
        if ($this->image) {
            $path = $this->getImagePath();
            if (is_file($path . $this->image)) {
                unlink($path . $this->image);
            }
        }
    }

    private function getImagePath(): string
    {
        return Yii::getAlias('@uploads') . '/ktch/';
    }

    public function beforeValidate()
    {
        $this->imageUpload = UploadedFile::getInstance($this, 'imageUpload');
        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%kitchens}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['description', 'string'],
            ['image', 'string', 'max' => 40],
            ['imageUpload', 'image', 'extensions' => 'jpg,jpeg,gif,png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'image' => 'Картинка',
            'imageUpload' => 'Картинка',
        ];
    }
}
