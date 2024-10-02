<?php
require "../../../vendor/autoload.php";
use LKGamesPublic\Controllers\UserController;

session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $user = new UserController();

        $me = $user->login(trim($_POST['username']),trim($_POST['password']));

        if($me != null)
        {
            if(!$me->getStatus()){
                // usuario Desactivado
                header("Location: ../../Pages/login.php?error=2");
                exit();
            }

            $_SESSION['userName'] = $me->getName();
            $_SESSION['userID'] = $me->getId_user();
            $_SESSION['userPermissionsLVL'] = $user->getPermissions($me->getId_user());

            header("Location: ../../index.php");
            exit();
        }
        else
        {
            // volver pero con error
            header("Location: ../../Pages/login.php?error=1");
            exit();
        }
    }
    else{
        header("Location: ../../Pages/login.php");
        exit();
    }




