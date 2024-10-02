<?php
require "../../../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $games = new GameBussiness();

        $juego_borrado = $games->delete($_POST['id_game']);

        if($juego_borrado)
        {
            // volver al listado con exito
            header("Location: ../../adminMenu.php?deleteComplete=1");
            exit();
        }
        else
        {
            // volver pero con error
            header("Location: ../../adminMenu.php?error=3");
            exit();
        }
    }
    else{
        header("Location: ../../../../../../public/Pages/404.php");
        exit();
    }




