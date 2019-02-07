<?php

namespace core\entities;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;
use Zelenin\yii\behaviors\Slug;

/**
 * This is the model class for table "{{%kitchens}}".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image [varchar(40)]
 * @property string $slug [varchar(255)]
 */
class Kitchen extends ActiveRecord
{
    public $imageUpload;

    public function getUrl(): string
    {
        return Url::to(['/kitchens/view', 'slug' => $this->slug]);
    }

    public function getPhotoUrl($forCP = false, $thumb = false): string
    {
        return ($forCP ? \Yii::$app->params['frontendHostInfo']: '') . '/uploads/ktch/' . (!$thumb ? $this->image : $this->getThumbName());
    }

    public function saveImage(UploadedFile $image): void
    {
        $baseName = $this->id . '_' . time();
        $name = $baseName . '.' . $image->extension;
        $thumbName = $baseName . '_sm.' . $image->extension;
        $path = $this->getImagePath();
        if ($image->saveAs($path . $name)) {
            Yii::$app->photoSaver->fitBySize($path . $name, 870, 570);
            Yii::$app->photoSaver->fitBySize($path . $name, 575, null, $path . $thumbName);
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
            $thumbFile = $this->getThumbName();
            if (is_file($path . $thumbFile)) {
                unlink($path . $thumbFile);
            }
        }
    }

    public function getImagePath(): string
    {
        return Yii::getAlias('@uploads') . '/ktch/';
    }

    public function getThumbName(): string
    {
        return pathinfo($this->image, PATHINFO_FILENAME) . '_sm.' . pathinfo($this->image, PATHINFO_EXTENSION);
    }

    public function beforeValidate()
    {
        $this->imageUpload = UploadedFile::getInstance($this, 'imageUpload');
        return parent::beforeValidate();
    }

    public function afterDelete()
    {
        $this->removeImages();
        parent::afterDelete();
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%kitchens}}';
    }

    public function behaviors()
    {
        return [
            'slug' => [
                'class' => Slug::class,
                'slugAttribute' => 'slug',
                'attribute' => 'name',
                'transliterateOptions' => 'Russian-Latin/BGN; Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'trim'],
            [['name'], 'string', 'max' => 255],
            ['description', 'string'],
            ['description', 'trim'],
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
