<?php
require "../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;

session_start();
if ((empty($_SESSION['userID']) || is_null($_SESSION['userID'])) && empty($_SESSION['userPermissionsLVL']) || $_SESSION['userPermissionsLVL'] != 3) {
    session_destroy();
    header("Location: /Proyecto_2/LK-Games/public/Pages/login.php");
    exit();
}

$games = new GameBussiness();
$listado_juegos = $games->all();

?>


<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <title>LK Games - Admin Menu</title>

    <link href="../../Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link href="../../Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php require __DIR__ . '../../../Pages/Partials/sideBar.php'?>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php require __DIR__ . '../../../Pages/Partials/topBar.php'?>

                <div class="container-fluid">

                    <p class="mb-4">Desde aquí podras Editar, Eliminar y Crear un nuevo post!</p>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Listado de juegos</h6>
                            <button class="btn btn-success btn-circle" style="cursor:pointer" onclick="window.location.href='gameAdminActions/createGame.php'"><i class="fas fa-plus"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Título</th>
                                            <th style="width: 10%;">Fecha de Salida</th>
                                            <th style="width: 35%;">Descripción</th>
                                            <th style="width: 35%;">Portada</th>
                                            <th style="width: 10%;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($listado_juegos as $juego) : ?>
                                            <tr>
                                                <td>
                                                    <p>
                                                        <a href="/Proyecto_2/LK-Games/public/Pages/game.php?id=<?php echo $juego->getId_game() ?>"><i class="fas fa-search" style="cursor:pointer"></i></a>
                                                        <?php echo $juego->getTitulo() ?>
                                                    </p>
                                                </td>
                                                <td>
                                                    <?php echo $juego->getFecha_salida() ?>
                                                </td>
                                                <td>
                                                    <p>
                                                        <?php echo $juego->getDescipcion() ?>
                                                    </p>
                                                </td>
                                                <td style="width: 300px; text-align: center;">
                                                    <?php echo $juego->getImgHTML() ?>
                                                </td>
                                                <td>
                                                    <div class="btn btn-primary btn-circle btn-sm" onclick="window.location.href='gameAdminActions/editGame.php?id=<?php echo $juego->getId_game() ?>'">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <div class="btn btn-danger btn-circle btn-sm" onclick="window.location.href='gameAdminActions/deleteGame.php?id=<?php echo $juego->getId_game() ?>'">
                                                        <i class="fas fa-trash"></i>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <?php require __DIR__ . '../../../Pages/Partials/footer.php'?>

        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>

    <?php
    if (isset($_GET["error"])) {

        if ($_GET["error"] == 1) {
            echo '<script type="text/javascript">
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.error("Error al editar, intentarlo nuevamente");
        </script>';
        }
    }

    if (isset($_GET["editComplete"]) && $_GET["editComplete"] == 1) {
        echo '<script type="text/javascript">
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success("Registro Actualizado");
            </script>';
    }
    else if(isset($_GET["createComplete"]) && $_GET["createComplete"] == 1)
    {
        echo '<script type="text/javascript">
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success("Registro Creado");
        </script>';
    }
    else if(isset($_GET["deleteComplete"]) && $_GET["deleteComplete"] == 1)
    {
        echo '<script type="text/javascript">
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr.success("Registro Eliminado");
        </script>';
    }
    ?>


</body>

</html>