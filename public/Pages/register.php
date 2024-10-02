<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <title>LK Games - Registro</title>
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

        .container-register {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.inline {
            display: flex;
        }

        .form-group.inline .form-control {
            flex: 1;
            margin-right: 10px;
        }
    </style>

</head>

<body class="bg">

    <div class="container-register">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Registro</h6>
                </div>
                <div class="card-body">
                    <form action="../BackOffice/Validators/register_validator.php" method="post" id="registrationForm">
                        <div class="form-group">
                            <?php if (isset($_GET["error"]) && $_GET["error"] == 1) : ?>
                                <div class="alert alert-danger" role="alert">
                                    Error: Nombre de usuario o email en uso.
                                </div>
                            <?php endif; ?>
                            <div class="form-group inline">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Nombre" required>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group inline">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirmar Contraseña" required>
                            </div>
                            <div id="passwordError" class="alert alert-danger" style="display:none;" role="alert">
                                Las contraseñas no coinciden.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión aquí</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#registrationForm').submit(function(event) {
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();
                if (password !== confirm_password) {
                    $('#passwordError').show();
                    event.preventDefault();
                } else {
                    $('#passwordError').hide();
                }
            });
        });
    </script>
</body>

</html>
