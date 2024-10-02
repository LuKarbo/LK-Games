<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <title>LK Games - Login</title>
    <link href="../Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        body,
        html {
            height: 100%;
        }

        .bg {
            background-color: darkgray;
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .container-login {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }
    </style>

</head>

<body class="bg">

    <div class="container-login">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Iniciar sesión</h6>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_GET["error"]) && $_GET["error"] == 1) {
                        echo '<div class="alert alert-danger" role="alert">
                                Error: Nombre de usuario o contraseña incorrectos.
                            </div>';
                    }
                    if (isset($_GET["error"]) && $_GET["error"] == 2) {
                        echo '<div class="alert alert-danger" role="alert">
                                Error: Usuario Desactivado, comunicarse con un Administrador para poder acceder.
                            </div>';
                    }
                    ?>
                    <form action="../BackOffice/Validators/login_validator.php" method="post">
                        <div class="form-group">
                            <label for="username">Usuario:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </form>
                    <div class="text-center mt-2">
                        <a href="register.php">¿No tienes una cuenta? Regístrate aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>

</body>

</html>