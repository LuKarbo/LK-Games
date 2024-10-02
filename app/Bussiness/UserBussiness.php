<?php

namespace LKGames\Bussiness;

use LKGames\DataAccess\UserDao;
use LKGames\Entity\UserEntity;
use LKGamesPublic\Controllers\UserController;

class UserBussiness
{
    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserController();
    }

    public function userLogin($name,$pass): ?UserEntity
    {
        return $this->userDao->login($name,$pass);
    }

    public function userRegister($name,$pass,$email): ?bool
    {
        return $this->userDao->register($name,$pass,$email);
    }

    public function userPassEdit(int $id, String $pass, String $newPass)
    {
        return $this->userDao->editPassUser($id,$pass,$newPass);
    }
    
    public function getPermissions($id): ?int
    {
        return $this->userDao->getPermissions($id);
    }

    public function userAll(): array{
        return $this->userDao->getAll();
    }

    public function userEdit(array $update, int $permisos, int $editID): UserEntity{
        return $this->userDao->edit($update, $permisos, $editID);
    }

    public function userDelete(int $id): bool{
        return $this->userDao->delete($id);
    }

}