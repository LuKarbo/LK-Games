<?php

namespace LKGames\Config;

class DBConfig{
    public static function getConn(){
        try {
            $pdo = new \PDO('mysql:host=localhost;dbname=lk_games', 'root', '');
        } catch (\PDOException $e) {
            var_dump($e);
        }

        return $pdo;
    }
}
