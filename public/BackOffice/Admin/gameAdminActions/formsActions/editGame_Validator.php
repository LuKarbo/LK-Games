<?php
require "../../../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $games = new GameBussiness();
        
        $post = [
            "titulo" => trim($_POST['titulo']),
            "fecha_salida" => trim($_POST['fecha_salida']),
            "descripcion" => trim($_POST['descripcion']),
            "img" => $_FILES['portada']
        ];

        $juego_editado = $games->edit($post,$_POST['id_game']);

        if($juego_editado != null)
        {
            // volver al listado con exito
            header("Location: ../../adminMenu.php?editComplete=1");
            exit();
        }
        else
        {
            // volver pero con error
            header("Location: ../editGame.php?id=".$_POST['id_game']."&error=1");
            exit();
        }
    }
    else{
        header("Location: ../../../../../../public/Pages/404.php");
        exit();
    }




