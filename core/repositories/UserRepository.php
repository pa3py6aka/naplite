<?php

namespace core\repositories;


use core\entities\User\User;

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