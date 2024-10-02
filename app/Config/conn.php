<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lk_games', 'root', '');
} catch (PDOException $e) {
    var_dump($e);
}
