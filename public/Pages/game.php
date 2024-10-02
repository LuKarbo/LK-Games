<?php

require "../../vendor/autoload.php";

use LKGames\Bussiness\GameBussiness;


session_start();
if (empty($_SESSION['userID']) || is_null($_SESSION['userID'])) {
    session_destroy();
    header("Location: /LK_Games/public/Pages/login.php");
    exit();
}

if (isset($_GET["id"]) && !empty($_GET["id"])) {
    $game = new GameBussiness();
    $game_data = $game->find($_GET["id"]);
} else {
    header("Location: 404.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <title>LK Games - <?php echo $game_data->getTitulo() ?></title>

    <link href="../Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php require __DIR__ . '/Partials/sideBar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php require __DIR__ . '/Partials/topBar.php'; ?>

                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo $game_data->getTitulo() ?></h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h1>Descripción:</h1>
                                    <p>
                                        <?php echo $game_data->getDescipcion() ?>
                                    </p>
                                    <h2>Fecha de Salida</h2>
                                    <p>
                                        <?php echo $game_data->getFecha_salida() ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <?php echo $game_data->getImgHTML() ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
            <?php require __DIR__ . '/Partials/footer.php'; ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>


</body>

</html>