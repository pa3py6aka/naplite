<?php

namespace core\services\auth;


use core\access\Rbac;
use core\entities\User\User;
use core\services\RoleManager;

class NetworkService
{
    private $roleManager;

    public function __construct(RoleManager $roleManager)
    {
        $this->roleManager = $roleManager;
    }

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
        $this->roleManager->assign($user->id, Rbac::ROLE_USER);
        return $user;
    }
}