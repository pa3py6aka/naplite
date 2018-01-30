<?php

namespace core\jobs;


use core\access\Rbac;
use core\entities\Recipe\Recipe;
use core\repositories\UserRepository;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class MailJob extends BaseObject implements JobInterface
{
    public $mailType;

    const TYPE_NEW_RECIPE = 'newRecipe';
    public $recipeId;

    public function execute($queue)
    {
        switch ($this->mailType) {
            case self::TYPE_NEW_RECIPE:
                $this->sendNewRecipeToAdmins();
                break;
        }
    }

    private function sendNewRecipeToAdmins()
    {
        if ($recipe = Recipe::findOne($this->recipeId)) {
            $admins = UserRepository::findByRoleName([Rbac::ROLE_MODERATOR, Rbac::ROLE_ADMIN]);
            foreach ($admins as $admin) {
                Yii::$app->mailer->compose(
                    ['html' => self::TYPE_NEW_RECIPE . '-html', 'text' => self::TYPE_NEW_RECIPE . '-text'],
                    ['recipe' => $recipe]
                )
                    ->setTo($admin->email)
                    ->setSubject('Добавлен новый рецепт. ' . Yii::$app->name)
                    ->send();
            }
        }
    }
}