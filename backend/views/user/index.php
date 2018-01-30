<?php

use core\grid\manage\RoleColumn;
use core\entities\User\User;
use core\helpers\UserHelper;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\AutoComplete;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel backend\forms\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index box box-primary">
    <!--<div class="box-header with-border">
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success btn-flat']) ?>
    </div>-->
    <div class="box-body table-responsive">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                //'id',
                [
                    'attribute' => 'username',
                    'value' => function (User $user) {
                        return Html::a($user->fullName, ['view', 'id' => $user->id]);
                    },
                    'format' => 'raw',
                    'filter' => AutoComplete::widget([
                        'model' => $searchModel,
                        'attribute' => 'username',
                        'clientOptions' => [
                            'source' => new JsExpression("function(request, response) {
                                $.getJSON('/user/auto-complete', {
                                    username: request.term
                                }, response);
                            }")
                        ],
                        'options' => [
                            'class' => 'form-control',
                        ]
                    ]),
                ],
                'email:email',

                //'country',
                //'city',
                // 'experience_id',
                // 'recipes',
                // 'about:ntext',
                // 'avatar',
                // 'rate',
                // 'status',
                // 'email_confirm_token:email',
                // 'auth_key',
                // 'password_hash',
                // 'password_reset_token',
                [
                    'attribute' => 'role',
                    'label' => 'Роль',
                    'class' => RoleColumn::class,
                    'filter' => $searchModel->rolesList(),
                ],
                [
                    'attribute' => 'status',
                    'filter' => UserHelper::statusList(),
                    'value' => function (User $user) {
                        return UserHelper::statusLabel($user->status);
                    },
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'created_at',
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'date_from',
                        'attribute2' => 'date_to',
                        'type' => DatePicker::TYPE_RANGE,
                        'separator' => '-',
                        'pluginOptions' => [
                            'todayHighlight' => true,
                            'autoclose'=>true,
                            'format' => 'dd.mm.yyyy',
                        ],
                    ]),
                    'format' => 'datetime',
                ],
                // 'updated_at',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
</div>
