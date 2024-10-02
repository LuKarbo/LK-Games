<?php
namespace LKGames\Bussiness;

use LKGames\DataAccess\Dao;
use LKGames\Entity\GameEntity;
use LKGamesPublic\Controllers\GameController;

class GameBussiness{
    private Dao $dao;

    public function __construct()
    {
        $this->dao = new GameController();
    }

    /**
     * @return GameEntity[]
     */
    public function all(): array
    {
        return $this->dao->all();
    }

    public function find($id)
    {
        return $this->dao->find($id);
    }

    public function dateFilter($fecha)
    {
        return $this->dao->dateFilter($fecha);
    }

    public function create(array $post): GameEntity
    {
        return $this->dao->create($post);
    }

    public function edit(array $update, int $editID): GameEntity
    {
        return $this->dao->edit($update, $editID);
    }

    public function delete(int $id): bool
    {
        return $this->dao->delete($id);
    }

}