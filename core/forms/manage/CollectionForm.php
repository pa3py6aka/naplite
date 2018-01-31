<?php

namespace core\forms\manage;


use core\entities\Recipe\Category;
use core\entities\Recipe\Collection\Collection;
use yii\base\Model;
use yii\web\UploadedFile;

class CollectionForm extends Model
{
    public $title;
    public $description;
    public $image;
    public $categoryId;

    private $_collection;

    public function __construct(Collection $collection = null, array $config = [])
    {
        if ($collection) {
            $this->title = $collection->title;
            $this->description = $collection->description;
            $this->categoryId = $collection->category_id;

            $this->_collection = $collection;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title', 'description'], 'required'],
            ['image', 'required', 'when' => function (CollectionForm $form) {
                return $form->_collection === null;
            }, 'whenClient' => "function (attribute, value) {
                return " . !$this->_collection . ";
            }"],
            [['title', 'description'], 'string'],
            ['image', 'image', 'extensions' => 'jpg, jpeg, gif, png', 'maxSize' => 1024 * 1024 * 3],
            ['categoryId', 'integer'],
            ['categoryId', 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryId' => 'id']],
        ];
    }

    public function beforeValidate()
    {
        $this->image = UploadedFile::getInstance($this, 'image');
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'image' => 'Картинка',
            'categoryId' => 'Раздел',
        ];
    }
}