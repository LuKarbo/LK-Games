<?php

namespace LKGames\DataAccess;

use LKGames\Entity\UserEntity;

abstract class UserDao
{

    /**
     * @return ?UserEntity
     */
    abstract public function login(String $name, String $pass): ?UserEntity;

    abstract public function register(String $name, String $pass, String $email): bool;

    abstract public function editPassUser(int $id, String $pass, String $newPass);

    /**
     * @return int
     */
    abstract public function getPermissions(int $id);

    abstract public function getAll() : array;

    abstract public function edit(array $update,int $permisos, int $editID): UserEntity;

    abstract public function delete(int $editID): bool;

    protected function hydrate(array $data): UserEntity
    {
        $entity = new UserEntity;
        $entity->setId_user($data['id_user']);
        $entity->setNombre($data['nombre']);
        $entity->setEmail($data['email']);
        $entity->setStatus($data['status']);

        return $entity;
    }
}