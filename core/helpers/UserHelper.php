<?php

namespace core\helpers;


use core\entities\User\User;
use yii\helpers\ArrayHelper;
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

    public static function statusList(): array
    {
        return [
            User::STATUS_DELETED => 'Заблокирован',
            User::STATUS_WAIT => 'Не подтверждён',
            User::STATUS_ACTIVE => 'Активен',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case User::STATUS_DELETED:
                $class = 'label label-danger';
                break;
            case User::STATUS_WAIT:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

}