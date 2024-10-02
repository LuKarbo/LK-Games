<?php

namespace LKGamesPublic\Controllers;

use LKGames\DataAccess\Dao;
use LKGames\Config\DBConfig;
use LKGames\Entity\GameEntity;
use LKGames\Bussiness\GameBussiness;

class GameController extends Dao{

    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConfig::getConn();
    }

    // all()
    public function all(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM game');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, GameEntity::class);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find(int $id): ?GameEntity{
        $stmt = $this->pdo->prepare('SELECT * FROM game WHERE id_game = :id');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, GameEntity::class);
        $stmt->execute([
            ':id' => $id
        ]);
        return $stmt->fetch();
    }

    public function dateFilter(string $fecha): array{
        $stmt = $this->pdo->prepare('SELECT * FROM game Where YEAR(fecha_salida) = :anio');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, GameEntity::class);
        $stmt->execute([
            ':anio' => $fecha
        ]);
        return $stmt->fetchAll();
    }


    public function create(array $data): ?GameEntity {
        $qry = "INSERT INTO game (";
        $placeholders = '';
    
        foreach ($data as $key => $value) {
            if ($key !== 'img') {
                $qry .= "$key,";
                $placeholders .= ":$key,";
            }
        }
    
        $qry .= "img";
        $placeholders .= ":img";
    
        $qry = rtrim($qry, ",");
        $placeholders = rtrim($placeholders, ",");
    
        $qry .= ") VALUES (";
        $qry .= "$placeholders)";
    
        $stmt = $this->pdo->prepare($qry);
    
        foreach ($data as $key => &$value) {
            if ($key === 'img') {
                $img = file_get_contents($value['tmp_name']);
                $stmt->bindParam(":$key", $img, \PDO::PARAM_LOB);
            } else {
                $stmt->bindParam(":$key", $value);
            }
        }
    
        $stmt->execute();
    
        $id = $this->pdo->lastInsertId();
    
        return $this->find($id);
    }
    

    public function edit(array $data, int $editID): ?GameEntity {
        $qry = "UPDATE game SET ";
        $execute = [];

        foreach ($data as $key => $value) {
            if ($key !== 'id_game') {
                if ($key === 'img') {
                    if (isset($value['tmp_name']) && file_exists($value['tmp_name'])) {
                        $img = file_get_contents($value['tmp_name']);
                        $execute[":$key"] = $img;
                    } else {
                        $games = new GameBussiness();
                        $game = $games->find($editID);
                        if ($game) {
                            $value = $game->getImg();
                        }
                        // Asignar el valor al parámetro de la consulta
                        $execute[":$key"] = $value;
                    }
                } else {
                    $execute[":$key"] = $value;
                }
                $qry .= "$key = :$key, ";
            }
        }

        $qry = rtrim($qry, ", ") . " WHERE id_game = :id_game";
        $execute[':id_game'] = $editID;

        $stmt = $this->pdo->prepare($qry);
        $stmt->execute($execute);

        $data["id_game"] = $editID;
        return $this->hydrate($data);
    }


    public function delete(int $id): bool{ 

        $result = $this->find($id);
        // verifico si existe en la base de datos ese ID
        if($result != null)
        {
            // lo elimino si existe
            $stmt = $this->pdo->prepare('DELETE FROM game WHERE id_game = :id');
            $stmt->setFetchMode(\PDO::FETCH_CLASS, GameEntity::class);
            $stmt->execute([
                ':id' => $id
            ]);
            return true;
        }
        else
        {
            return false;
        }
    }

}