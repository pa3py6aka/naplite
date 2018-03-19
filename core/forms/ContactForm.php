<?php

namespace core\forms;


use yii\base\Model;

class ContactForm extends Model
{
    public $email;
    public $name;
    public $subject;
    public $text;

    public function rules()
    {
        return [
            ['email', 'required', 'message' => 'Укажите ваш e-mail'],
            ['email', 'email'],
            [['name', 'subject', 'text'], 'string'],
            [['name', 'subject', 'text'], 'trim'],
            ['text', 'required', 'message' => 'Напишите текст вашего сообщения']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'name' => 'Ваше имя',
            'subject' => 'Тема сообщения',
            'text' => 'Текст сообщения',
        ];
    }
}