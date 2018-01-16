<?php

namespace console\controllers;


use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\ArrayHelper;

class RoleController extends Controller
{
    /**
     * Adds role to user
     */
    public function actionAssign()
    {
        $email = $this->prompt('E-mail:', ['required' => true]);
        $user = $this->findModel($email);
        $role = $this->select('Role:', ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description'));

        $manager = Yii::$app->authManager;
        if (!$role = $manager->getRole($role)) {
            throw new \DomainException('Role "' . $role->name . '" does not exist.');
        }
        $manager->revokeAll($user->id);
        $manager->assign($role, $user->id);

        $this->stdout('Done!' . PHP_EOL);
    }

    private function findModel($email)
    {
        if (!$model = User::findOne(['email' => $email])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}