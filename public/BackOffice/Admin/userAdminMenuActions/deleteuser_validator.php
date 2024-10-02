<?php
require "../../../../vendor/autoload.php";
use LKGames\Bussiness\UserBussiness;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $user = new UserBussiness();
        $delted_user = $user->userDelete($_POST["user_id_delete"]);

        if($delted_user)
        {
            // volver al listado con exito
            header("Location: ../userAdminMenu.php?success=2");
            exit();
        }
        else
        {
            // volver pero con error
            header("Location: ../userAdminMenu.php?error=2");
            exit();
        }
        
    }
    else{
        header("Location: ../../../../Pages/404.php");
        exit();
    }




