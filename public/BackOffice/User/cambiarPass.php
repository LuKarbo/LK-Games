<?php
    session_start();
    if ((empty($_SESSION['userID']) || is_null($_SESSION['userID']))) {
        session_destroy();
        header("Location: /Proyecto_2/LK-Games/public/Pages/login.php");
        exit();
    }
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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Cambiar Contraseña</h6>
                        </div>
                        <div class="card-body">
                            <form id="cambiarPassForm" action="formsUserActions/cambiarPass_Validator.php" method="POST">
                                <div class="row">
                                    <?php
                                        if (isset($_GET["error"]) && $_GET["error"] == 1) {
                                            echo '<div class="alert alert-danger mt-3 col-lg-12" role="alert">
                                                    Error: Debe de ingresar su contraseña actual.
                                                </div>';
                                        }
                                        if (isset($_GET["error"]) && $_GET["error"] == 2) {
                                            echo '<div class="alert alert-danger mt-3 col-lg-12" role="alert">
                                                    Error: La contraseña nueva debe de ser diferente a la actual.
                                                </div>';
                                        }
                                        if (isset($_GET["error"]) && $_GET["error"] == 3) {
                                            echo '<div class="alert alert-danger mt-3 col-lg-12" role="alert">
                                                    Error: Fallo al actualizar la contraseña.
                                                </div>';
                                        }
                                    ?>
                                    <div class="form-group col-lg-5">
                                        <label for="titulo">Contraseña Actual</label>
                                        <input type="password" class="form-control" id="pass" name="pass" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="errorMensaje" class="alert alert-danger mt-3 d-none col-lg-12" role="alert">
                                        Error: Las contraseñas deben ser iguales.
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="fecha_salida">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="newPass" name="newPass" required>
                                    </div>
                                    <div class="form-group col-lg-5">
                                        <label for="descripcion">Confirmar Contraseña Nueva</label>
                                        <input type="password" class="form-control" id="newPass_confirm" name="newPass_confirm" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-info" onclick="validarContraseñas()">Confirmar</button>
                            </form>
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
    function validarContraseñas() {
        var newPass = document.getElementById('newPass').value;
        var newPass_confirm = document.getElementById('newPass_confirm').value;

        if (newPass !== newPass_confirm) {
            document.getElementById('errorMensaje').classList.remove('d-none');
        } else {
            document.getElementById('errorMensaje').classList.add('d-none');
            document.getElementById('cambiarPassForm').submit();
        }
    }
</script>

</body>

</html>