<?php

namespace core\forms\User;


use core\components\Subscriber;
use core\entities\User\User;
use yii\base\Model;
use yii\web\UploadedFile;

class UserSettingsForm extends Model
{
    public $username;
    public $email;
    public $country;
    public $city;
    public $about;
    public $subscribeCommentsNotify;
    public $subscribeHolidays;
    public $avatar;

    private $_user;

    public function __construct(User $user, array $config = [])
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->country = $user->country_id;
        $this->city = $user->city;
        $this->about = $user->about;
        $this->subscribeCommentsNotify = $user->getSubscribeFor(Subscriber::SB_COMMENTS_NOTIFY);
        $this->subscribeHolidays = $user->getSubscribeFor(Subscriber::SB_HOLIDAYS);
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            ['username', 'required', 'message' => 'Укажите ваше имя'],
            ['username', 'string', 'min' => 2, 'max' => 50],

            ['email', 'required', 'message' => 'Укажите ваш email'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => ['<>', 'id', $this->_user->id]],

            ['country', 'required', 'message' => 'Выберите вашу страну'],
            ['country', 'integer'],

            ['city', 'required', 'message' => 'Укажите ваш город'],
            ['city', 'string', 'min' => 2, 'max' => 50],

            ['about', 'string', 'max' => 2000],

            ['subscribeCommentsNotify', 'boolean'],
            ['subscribeHolidays', 'boolean'],

            ['avatar', 'image', 'extensions' => 'jpg, jpeg, png, gif', 'maxSize' => 1024 * 1024 * 3],
        ];
    }

    public function beforeValidate()
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя',
            'email' => 'Email',
            'country' => 'Страна',
            'city' => 'Город',
            'about' => 'О себе',
            'subscribeCommentsNotify' => 'Подписка на комментарии к рецептам',
            'subscribeHolidays' => 'Подписка на рецепты к праздникам',
            'avatar' => 'Фото',
        ];
    }
}