<?php

namespace Domain\User;

use App\Entity\User;
use App\Repository\UserRepository;

class UserRegistration
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registerValidUser(User $user): void
    {
        $this->repository->add($user, true);
    }
}
