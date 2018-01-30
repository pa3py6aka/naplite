<?php

use core\access\Rbac;
use core\entities\User\User;
use core\grid\manage\RoleColumn;
use core\helpers\UserHelper;
use yii\helpers\Html;
use yii\rbac\Item;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model core\entities\User\User */

$this->title = $model->fullName;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view box box-primary">
    <div class="box-header">
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>
        <?= Html::a('Сменить пароль', ['change-password', 'id' => $model->id], ['class' => 'btn btn-primary btn-flat']) ?>

        <?php if (Yii::$app->user->can(Rbac::ROLE_ADMIN) && isset(Yii::$app->authManager->getRolesByUser($model->id)[Rbac::ROLE_USER])) {
            echo Html::a('Сделать модератором', ['assign', 'id' => $model->id, 'role' => Rbac::ROLE_MODERATOR], [
                'class' => 'btn btn-warning btn-flat',
                'data' => [
                    'confirm' => 'Установить модератора?',
                    'method' => 'post',
                ]
            ]);
        } else if (Yii::$app->user->can(Rbac::ROLE_ADMIN)) {
            echo Html::a('Сделать обычным пользователем', ['assign', 'id' => $model->id, 'role' => Rbac::ROLE_USER], [
                'class' => 'btn btn-warning btn-flat',
                'data' => [
                    'confirm' => 'Сделать пользователя обычным?',
                    'method' => 'post',
                ]
            ]);
        } ?>

        <?php if ($model->status !== User::STATUS_ACTIVE) {
            echo Html::a('Активировать', ['activate', 'id' => $model->id], [
                'class' => 'btn btn-success btn-flat',
                'data' => [
                    'confirm' => 'Активировать этого пользователя?',
                    'method' => 'post',
                ]
            ]);
        } else {
            echo Html::a('Заблокировать', ['block', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-flat',
                'data' => [
                    'confirm' => 'Заблокировать этого пользователя?',
                    'method' => 'post',
                ]
            ]);
        } ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-flat',
            'data' => [
                'confirm' => 'Удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
        <?php if ($model->avatar): ?>
            <img src="<?= $model->avatarUrl ?>" class="img-responsive" style="margin-top:10px;">&nbsp;&nbsp;
        <?php endif; ?>
    </div>
    <div class="box-body table-responsive no-padding">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'email:email',
                'fullName',
                [
                    'label' => 'Страна',
                    'value' => function (User $user) {
                        return $user->country_id ? $user->country->name : null;
                    }
                ],
                'city',
                [
                    'label' => 'Опытность',
                    'value' => function (User $user) {
                        return $user->experience->name;
                    }
                ],
                'recipes_count',
                'about:ntext',
                'rate',
                [
                    'label' => 'Статус',
                    'value' => function (User $user) {
                        return UserHelper::statusLabel($user->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Роль',
                    'value' => function (User $user) {
                        $roles = Yii::$app->authManager->getRolesByUser($user->id);
                        return $roles === [] ? $this->grid->emptyCell : implode(', ', array_map(function (Item $role) {
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
                        }, $roles));
                    },
                    'format' => 'raw',
                ],
                //'email_confirm_token:email',
                //'auth_key',
                //'password_hash',
                //'password_reset_token',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>
    </div>
</div>
