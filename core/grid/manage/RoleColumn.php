<?php
namespace core\grid\manage;


use core\access\Rbac;
use Yii;
use yii\grid\DataColumn;
use yii\helpers\Html;
use yii\rbac\Item;

class RoleColumn extends DataColumn
{
    protected function renderDataCellContent($model, $key, $index): string
    {
        $roles = Yii::$app->authManager->getRolesByUser($model->id);
        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role) {
            return $this->getRoleLabel($role);
        }, $roles));
    }

    private function getRoleLabel(Item $role): string
    {
        switch ($role->name) {
            case Rbac::ROLE_USER:
                $class = 'primary';
                break;
            case Rbac::ROLE_BLOCKED:
                $class = 'danger';
                break;
            case Rbac::ROLE_MODERATOR:
                $class = 'warning';
                break;
            case Rbac::ROLE_ADMIN:
                $class = 'danger';
                break;
            default: $class = 'default';
        }
        return Html::tag('span', Html::encode($role->description), ['class' => 'label label-' . $class]);
    }
}