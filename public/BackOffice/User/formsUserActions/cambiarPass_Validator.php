<?php
require "../../../../vendor/autoload.php";
use LKGamesPublic\Controllers\UserController;

session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
        $user = new UserController();
        $user->editPassUser($_SESSION['userID'],trim($_POST['pass']),trim($_POST['newPass']));
    }
    else{
        header("Location: ../cambiarPass.php");
        exit();
    }




