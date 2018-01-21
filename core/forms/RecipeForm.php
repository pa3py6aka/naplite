<?php

namespace core\forms;


use core\entities\Category;
use core\entities\Holiday;
use core\entities\Kitchen;
use core\entities\Recipe;
use yii\base\Model;

class RecipeForm extends Model
{
    public $name;
    public $categoryId;
    public $kitchenId;
    public $mainPhoto;
    public $photos;
    public $introductoryText;
    public $cookingTimeHours = 0;
    public $cookingTimeMinutes = '00';
    public $preparationTimeHours = 0;
    public $preparationTimeMinutes = '00';
    public $persons;
    public $holidays;
    public $holidaysInput;
    public $complexity;
    public $notes;
    public $ingredientSection;
    public $ingredientName;
    public $ingredientQuantity;
    public $ingredientUom;
    public $stepDescription;
    public $stepPhoto;
    public $commentsNotify;

    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Напишите название рецепта'],
            ['name', 'string', 'min' => 2, 'max' => 255],

            ['categoryId', 'required', 'message' => 'Выберите категорию'],
            ['categoryId', 'integer'],
            [['categoryId'], 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['categoryId' => 'id']],

            ['kitchenId', 'required', 'message' => 'Укажите кухню мира'],
            ['kitchenId', 'integer'],
            [['kitchenId'], 'exist', 'skipOnError' => false, 'targetClass' => Kitchen::className(), 'targetAttribute' => ['kitchenId' => 'id']],

            ['photos', 'required', 'message' => 'Необходимо добавить фото рецепта'],
            ['photos', 'each', 'rule' => ['string']],

            ['mainPhoto', 'integer'],

            ['introductoryText', 'required', 'message' => 'Напишите вводный текст'],
            ['introductoryText', 'string', 'min' => 20, 'max' => \Yii::$app->settings->get(''), 'message' => 'Текст должен быть от 20 до 500 символов'],

            [['cookingTimeHours', 'cookingTimeMinutes'], 'required', 'message' => 'Укажите время приготовления'],
            ['cookingTimeHours', 'integer', 'max' => 30],
            ['cookingTimeMinutes', 'integer', 'max' => 59],

            [['preparationTimeHours', 'preparationTimeMinutes'], 'required', 'message' => 'Укажите время подготовки'],
            ['preparationTimeHours', 'integer', 'max' => 50],
            ['preparationTimeMinutes', 'integer', 'max' => 59],

            ['persons', 'required', 'message' => 'Укажите кол-во персон'],
            ['persons', 'integer', 'min' => 1, 'max' => 10],

            ['holidays', 'required', 'message' => 'Выберите праздники'],
            ['holidays', 'each', 'rule' => ['integer']],
            ['holidays', 'each', 'rule' => ['exist', 'skipOnError' => false, 'targetClass' => Holiday::className(), 'targetAttribute' => 'id']],
            ['holidaysInput', 'required', 'message' => 'Выберите праздники'],
            ['holidaysInput', 'string'],

            ['complexity', 'required', 'message' => 'Укажите сложность'],
            ['complexity', 'integer'],
            ['complexity', 'in', 'range' => array_keys(Recipe::complexities())],

            //['ingredientSection', 'required'],
            ['ingredientSection', 'each', 'rule' => ['string', 'min' => 2, 'max' => 255]],

            ['ingredientName', 'required'],
            ['ingredientName', 'each', 'rule' => ['each', 'rule' => ['string', 'min' => 2, 'max' => 255]]],

            ['ingredientQuantity', 'required'],
            ['ingredientQuantity', 'each', 'rule' => ['each', 'rule' => ['match', 'pattern' => '/^[0-9]+((\.|,)[0-9]+)*$/uis']]],

            ['ingredientUom', 'required'],
            ['ingredientUom', 'each', 'rule' => ['each', 'rule' => ['string', 'min' => 2, 'max' => 70]]],

            ['stepDescription', 'required'],
            ['stepDescription', 'each', 'rule' => ['string', 'min' => 10, 'max' => 20000]],

            ['stepPhoto', 'each', 'rule' => ['string']],

            ['notes', 'required', 'message' => 'Напишите совет'],
            ['notes', 'string', 'min' => 10, 'max' => 5000],

            ['commentsNotify', 'boolean'],
        ];
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'categoryId' => 'Категория',
            'notes' => 'Совет'
        ];
    }

    public function personsArray()
    {
        return [1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10];
    }
}