<?php

namespace core\services\auth;


use core\entities\User\User;

class NetworkService
{
    /**
     * @param $network
     * @param $identity
     * @return User
     */
    public function auth($network, $identity)
    {
        if ($user = User::findByNetworkIdentity($network, $identity)) {
            return $user;
        }
        $user = User::signupByNetwork($network, $identity);
        if (!$user->save()) {
            throw new \DomainException("Ошибка сохранения нового пользователя.");
        }
        return $user;
    }
}