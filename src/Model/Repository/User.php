<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Repository\IdentityMapper;
use Model\Entity\User as UserEntity;
use Model\Entity\Role as RoleEntity;

class User
{
    /** @property IdentityMapper $manager */
    private $manager;

    public function __construct()
    {
        $this->manager = new IdentityMapper(UserEntity::class);
    }

    /**
     * Получаем пользователя по идентификатору
     *
     * @param int $id
     * @return UserEntity|null
     */
    public function getById(int $id): ?UserEntity
    {
        foreach ($this->getDataFromSource(['id' => $id]) as $user) {
            return $this->getOrCreateUser($user);
        }

        return null;
    }

    /**
     * Получаем пользователя по логину
     *
     * @param string $login
     * @return UserEntity
     */
    public function getByLogin(string $login): ?UserEntity
    {
        foreach ($this->getDataFromSource(['login' => $login]) as $user) {
            if ($user['login'] === $login) {
                return $this->getOrCreateUser($user);
            }
        }

        return null;
    }

    /**
     * Фабрика по созданию сущности пользователя
     *
     * @param array $user
     * @return UserEntity
     */
    private function createUser(array $user): UserEntity
    {
        $role = $user['role'];

        return new UserEntity(
            $user['id'],
            $user['name'],
            $user['login'],
            $user['password'],
            new RoleEntity($role['id'], $role['title'], $role['role'])
        );
    }

    private function getOrCreateUser(array $user): UserEntity
    {
        if (!$userEntity = $this->manager->find((int)$user['id'])) {
            $userEntity = $this->createUser($user);
            $this->manager->add($userEntity);
        }

        return $userEntity;
    }

    /**
     * Получаем пользователей из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $admin = ['id' => 1, 'title' => 'Super Admin', 'role' => 'admin'];
        $user = ['id' => 2, 'title' => 'Main user', 'role' => 'user'];
        $test = ['id' => 3, 'title' => 'For test needed', 'role' => 'test'];

        $dataSource = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'login' => 'root',
                'password' => '$2y$10$GnZbayyccTIDIT5nceez7u7z1u6K.znlEf9Jb19CLGK0NGbaorw8W', // 1234
                'role' => $admin
            ],
            [
                'id' => 2,
                'name' => 'Doe John',
                'login' => 'doejohn',
                'password' => '$2y$10$j4DX.lEvkVLVt6PoAXr6VuomG3YfnssrW0GA8808Dy5ydwND/n8DW', // qwerty
                'role' => $user
            ],
            [
                'id' => 3,
                'name' => 'Ivanov Ivan Ivanovich',
                'login' => 'i**3',
                'password' => '$2y$10$TcQdU.qWG0s7XGeIqnhquOH/v3r2KKbes8bLIL6NFWpqfFn.cwWha', // PaSsWoRd
                'role' => $user
            ],
            [
                'id' => 4,
                'name' => 'Test Testov Testovich',
                'login' => 'testok',
                'password' => '$2y$10$vQvuFc6vQQyon0IawbmUN.3cPBXmuaZYsVww5csFRLvLCLPTiYwMa', // testss
                'role' => $test
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $userFilter = function (array $dataSource) use ($search): bool {
            return (bool) array_intersect($dataSource, $search);
        };

        return array_filter($dataSource, $userFilter);
    }
}
