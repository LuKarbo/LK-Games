<?php

require "../../../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $post = [
            "titulo" => trim($_POST['titulo']),
            "fecha_salida" => trim($_POST['fecha_salida']),
            "descripcion" => trim($_POST['descripcion']),
            "img" => $_FILES['portada']
        ];

        $games = new GameBussiness();
        $juego_creado = $games->create($post);
        if($juego_creado != null)
        {
            // volver al listado con exito
            header("Location: ../../adminMenu.php?createComplete=1");
            exit();
        }
        else
        {
            // volver pero con error
            header("Location: ../createGame.php?error=1");
            exit();
        }
    }
    else{
        header("Location: ../../../../../../public/Pages/404.php");
        exit();
    }




