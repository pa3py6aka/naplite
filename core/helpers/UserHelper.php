<?php

namespace core\helpers;


use core\entities\User\User;
use yii\helpers\Html;

class UserHelper
{
    public static function getResidency(User $user)
    {
        $result = '';
        if ($user->country_id) {
            $result = $user->country->name;
        }
        if ($user->country_id && $user->city) {
            $result .= ', ';
        }
        if ($user->city) {
            $result .= Html::encode($user->city);
        }
        return $result;
    }
}