<?php
require "../../../vendor/autoload.php";
    use LKGamesPublic\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = new UserController();

    $registro = $user->register(trim($_POST['username']), trim($_POST['password']), trim($_POST['email']));

    if ($registro) {
        // entro por el true
        header("Location: ../../Pages/login.php");
        exit();
    } else {
        // entro por el false
        header("Location: ../../Pages/register.php?error=1");
        exit();
    }
} else {
    header("Location: ../../Pages/register.php");
    exit();
}
