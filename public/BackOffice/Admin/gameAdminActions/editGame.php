<?php

require "../../../../vendor/autoload.php";
use LKGames\Bussiness\GameBussiness;

session_start();
if ((empty($_SESSION['userID']) || is_null($_SESSION['userID'])) && empty($_SESSION['userPermissionsLVL']) || $_SESSION['userPermissionsLVL'] != 3) {
    session_destroy();
    header("Location: /Proyecto-2/LK-Games/public/Pages/login.php");
    exit();
}

require "../../../../vendor/autoload.php";
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

    <title>LK Games - Editar Juego</title>

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
                    <h1 class="h3 mb-4 text-gray-800">Editar Juego</h1>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Formulario de Edición de Juego</h6>
                        </div>
                        <div class="card-body">
                            <form action="formsActions/editGame_Validator.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="number" class="form-control" id="id_game" name="id_game" value="<?php echo $game_data->getId_game() ?>" hidden>
                                </div>
                                <div class="form-group">
                                    <label for="titulo">Título</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $game_data->getTitulo() ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_salida">Fecha de Salida</label>
                                    <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?php echo $fecha_salida_formateada ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo $game_data->getDescipcion() ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="portada_actual">Portada Actual</label><br>
                                    <div style="width: 300px;">
                                        <?php echo $game_data->getImgHTML() ?>
                                    </div>
                                    <label for="portada">Cambiar Portada (máximo 2MB)</label>
                                    <div>
                                        <input type="file" id="portada" name="portada" accept="image/*" onchange="validarArchivo()">
                                    </div>
                                    <div class="alert alert-danger" role="alert" id="errorFileSizeMessage" style="display: none; width:60%">
                                        Error: El archivo supera el límite de 2MB. Por favor, ingresa uno más pequeño.
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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

    <script>
        // valido que el archivo no sea superior a 2mb
        function validarArchivo() {
            var input = document.getElementById('portada');
            var errorFileSizeMessage = document.getElementById('errorFileSizeMessage');
            
            if (input.files.length > 0) {
                var fileSize = input.files[0].size;
                var maxSize = 2 * 1024 * 1024; // 2MB en bytes
                
                // Validar tamaño del archivo
                if (fileSize > maxSize) {
                    errorFileSizeMessage.style.display = 'block';
                    input.value = '';
                } else {
                    errorFileSizeMessage.style.display = 'none';
                }
            } else {
                errorFileSizeMessage.style.display = 'none';
            }
        }
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
    ?>
</body>
</html>
