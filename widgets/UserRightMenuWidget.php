<?php

namespace widgets;


use Yii;
use yii\base\Widget;
use yii\helpers\Url;

class UserRightMenuWidget extends Widget
{
    public $userId;

    public function run()
    {
        $action = Yii::$app->controller->action->id;
        return $this->render('user-menu-block', ['userId' => $this->userId, 'action' => $action]);
    }

    public static function getUrl($action, $currentAction, $userId, $title)
    {
        $url = $action == $currentAction ? 'javascript:void(0)' : Url::to(['/users/'. $action, 'id' => $userId]);
        $class = $action == $currentAction ? ' class="right_menu_active"' : '';
        return '<a href="' . $url . '"' . $class . '>' . $title . '</a>';
    }
}