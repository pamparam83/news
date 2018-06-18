<?php

namespace core\services\manage;

use core\entities\User\User;
use core\forms\User\UserCreateForm;
use core\forms\User\UserEditForm;
use core\repositories\UserRepository;
use core\services\RoleManager;
use core\services\TransactionManager;

class UserManageService
{
    private $repository;
    private $roles;
    private $transaction;
    /**
     * @var Newsletter
     */
    private $newsletter;

    public function __construct(
        UserRepository $repository,
        RoleManager $roles,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->roles = $roles;
        $this->transaction = $transaction;
    }

    /**
     * @param UserCreateForm $form
     * @return User
     * @throws \yii\base\Exception
     */
    public function create(UserCreateForm $form)
    {
//        print_r($form);exit;
        $user = User::create(
            $form->username,
            $form->email,
            $form->password
                   );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        $this->repository->save($user);
        return $user;
    }

    /**
     * @param $id
     * @param UserEditForm $form
     * @throws \Exception
     */
    public function edit($id, UserEditForm $form)
    {
        $user = $this->repository->get($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->phone
        );
        $this->transaction->wrap(function () use ($user, $form) {
            $this->repository->save($user);
            $this->roles->assign($user->id, $form->role);
        });
        $this->repository->save($user);
    }

    public function assignRole($id, $role)
    {
        $user = $this->repository->get($id);
        $this->roles->assign($user->id, $role);
    }

    public function remove($id)
    {
        $user = $this->repository->get($id);
        $this->repository->remove($user);
    }
}