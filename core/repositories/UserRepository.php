<?php

namespace core\repositories;


use core\entities\Recipe;
use core\entities\User\User;
use yii\data\ActiveDataProvider;

class UserRepository
{
    /**
     * @param $id
     * @return User
     */
    public function get($id)
    {
        if (!$user = User::findOne($id)) {
            throw new NotFoundException('Пользователь не найден.');
        }
        return $user;
    }

    public function getRecipesProviderByUserId($id): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Recipe::find()
                ->active()
                ->andWhere(['author_id' => $id]),
            'pagination' => ['pageSize' => 1, 'defaultPageSize' => 1],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
    }

    public static function findByRoleName($roleName): array
    {
        return User::find()
            ->alias('u')
            ->innerJoin('{{%auth_assignments}} a', 'a.user_id = u.id')
            ->andWhere(['a.item_name' => $roleName])
            ->all();
    }

    public function save(User $user)
    {
        if (!$user->save(false)) {
            throw new \RuntimeException('Ошибка записи в базу.');
        }
    }

    public function remove(User $user)
    {
        if (!$user->delete()) {
            throw new \RuntimeException('Ошибка при удалении из базы.');
        }
    }
}