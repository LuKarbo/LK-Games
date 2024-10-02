<?php
require "../../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;

session_start();
if ((empty($_SESSION['userID']) || is_null($_SESSION['userID'])) && empty($_SESSION['userPermissionsLVL']) || $_SESSION['userPermissionsLVL'] != 3) {
    session_destroy();
    header("Location: /Proyecto-2/LK-Games/public/Pages/login.php");
    exit();
}

    if(isset($_GET["id"]) && !empty($_GET["id"]))
    {
        $game = new GameBussiness();
        $game_data = $game->find($_GET["id"]);
        $fecha_salida = $game_data->getFecha_salida();
        $fecha_salida_formateada = date("Y-m-d", strtotime(str_replace('/', '-', $fecha_salida)));
    }
    else{
        header("Location: ../../../../Pages/404.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>LK Games - Eliminar Juego</title>
    <link href="../../../Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link href="../../../Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../../Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <?php require __DIR__ . '../../../../Pages/Partials/sideBar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php require __DIR__ . '../../../../Pages/Partials/topBar.php'; ?>

                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800">Eliminar Juego</h1>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Confirmar Eliminación</h6>
                        </div>
                        <div class="card-body">
                            <form action="formsActions/deleteGame_Validator.php" method="POST">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="id_game" name="id_game" value="<?php echo $game_data->getId_game() ?>" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $game_data->getTitulo() ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_salida">Fecha de Salida</label>
                                    <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?php echo $fecha_salida_formateada ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" readonly><?php echo $game_data->getDescipcion() ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="portada">Portada</label><br>
                                    <div style="width: 300px;">
                                        <?php echo $game_data->getImgHTML() ?>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmDeleteModal">Eliminar</button>
                                
                                <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar este juego?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <?php require __DIR__ . '../../../../Pages/Partials/footer.php'; ?>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

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
            toastr.error("Error al eliminar, intentarlo nuevamente");
        </script>';
        }
    }
    ?>
</body>
</html>
