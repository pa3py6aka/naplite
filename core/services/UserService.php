<?php

namespace core\services;


use core\components\Subscriber;
use core\entities\User\User;
use core\forms\User\UserSettingsForm;
use core\repositories\UserRepository;
use Yii;
use yii\web\UploadedFile;

class UserService
{
    private $transaction;
    private $repository;

    public function __construct(TransactionManager $transaction, UserRepository $repository)
    {
        $this->transaction = $transaction;
        $this->repository = $repository;
    }

    public function edit(UserSettingsForm $form, User $user): void
    {
        $subscribes = $user->subscribes;
        $subscribes[Subscriber::SB_COMMENTS_NOTIFY] = $form->subscribeCommentsNotify;
        $subscribes[Subscriber::SB_HOLIDAYS] = $form->subscribeHolidays;

        if ($form->avatar instanceof UploadedFile) {
            $user->saveAvatar($form->avatar);
        }
        $user->edit(
            $form->username,
            $form->email,
            $form->country,
            $form->city,
            $form->about,
            $subscribes
        );
        $this->repository->save($user);
    }
}