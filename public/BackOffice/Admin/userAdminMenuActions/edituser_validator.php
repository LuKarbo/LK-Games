<?php

require "../../../../vendor/autoload.php";
use LKGames\Bussiness\UserBussiness;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $post = [];
        if(isset($_POST['user_status'])){
            $post = [
                "nombre" => trim($_POST['user_name']),
                "email" => trim($_POST['user_email']),
                "status" => 1
            ];
            
            $user = new UserBussiness();
            $user_edit = $user->userEdit($post,$_POST['user_permisos'],$_POST['user_id']);
            if($user_edit != null)
            {
                // volver al listado con exito
                header("Location: ../userAdminMenu.php?success=1");
                exit();
            }
            else
            {
                // volver pero con error
                header("Location: ../userAdminMenu.php?error=1");
                exit();
            }
        }
        else{
            $post = [
                "status" => 0
            ];

            $user = new UserBussiness();
            $user_edit = $user->userEdit($post,0,$_POST['user_id']);
            if($user_edit != null)
            {
                // volver al listado con exito
                header("Location: ../userAdminMenu.php");
                exit();
            }
            else
            {
                // volver pero con error
                header("Location: ../userAdminMenu.php?error=1");
                exit();
            }
            }

        
    }
    else{
        header("Location: ../../../../Pages/404.php");
        exit();
    }




