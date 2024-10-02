<?php

namespace LKGames\DataAccess;

use LKGames\Entity\GameEntity;

abstract class Dao
{
    /**
     * @return GameEntity[]
     */
    abstract public function all(): array;

    /**
     * @return ?GameEntity
     */
    abstract public function find(int $id): ?GameEntity;

    /**
     * @return GameEntity[]
     */
    abstract public function dateFilter(String $fecha): array;

    abstract public function create(array $data): ?GameEntity;

    abstract public function edit(array $data, int $editID): ?GameEntity;

    abstract public function delete(int $id): bool;

    protected function hydrate(array $data): GameEntity
    {
        $entity = new GameEntity;
        $entity->setId_game($data['id_game']);
        $entity->setTitulo($data['titulo']);
        $entity->setFecha_salida($data['fecha_salida']);
        $entity->setDescripcion($data['descripcion']);
        $entity->setImg($data['img']);

        return $entity;
    }

}
