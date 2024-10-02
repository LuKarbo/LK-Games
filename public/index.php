<?php
require "../vendor/autoload.php";
    use LKGames\Bussiness\GameBussiness;


    session_start();
    if(empty($_SESSION['userID']) || is_null($_SESSION['userID']))
    {
        session_destroy();
        header("Location: /Proyecto_2/LK-Games/public/Pages/login.php");
        exit();
    }

    $games = new GameBussiness();
    $listado_juegos;

    if(!isset($_GET["fecha"])){
        $listado_juegos = $games->all();
    }
    else{
        if(empty($_GET["fecha"]))
        {
            header("Location: index.php");
            exit();
        }
        else{
            $listado_juegos = $games->dateFilter($_GET["fecha"]);
        }
    }

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <title>LK Games - Juegos</title>

    <link href="Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="Styles/Style/style.css" rel="stylesheet" type="text/css">

    <link href="Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <?php require __DIR__ . '/Pages/Partials/sideBar.php'; ?>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php require __DIR__ . '/Pages/Partials/topBar.php'; ?>

                <div class="container-fluid">
                    <?php
                        if(!isset($_GET["fecha"])){
                            echo "<h1 class='h3 mb-2 text-gray-800'>Juegos</h1>";
                            echo "<p class='mb-4'>Últimos juegos actualizados!</p>";
                        }
                        else{
                            echo "<h1 class='h3 mb-2 text-gray-800'>Juegos del año [" . $_GET["fecha"] . "]</h1>";
                            echo "<p class='mb-4'>Últimos juegos actualizados del año [" . $_GET["fecha"] . "]</p>";
                        }
                    ?>
                    
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Listado de juegos</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <form id="form"  action="index.php" method="GET">
                                        <div class="form-group">
                                            <label for="fecha"></label>
                                            <select name="fecha" id="fecha" class="form-control">
                                                <?php
                                                    if(!isset($_GET["fecha"])){
                                                        echo "<option value=''>Seleccionar Año de Salida</option>";
                                                    }
                                                    else{
                                                        echo "<option value='" . $_GET["fecha"] . "'>" . $_GET["fecha"] . "</option>";
                                                    }
                                                    
                                                    for ($i = 2012; $i <= 2024; $i++){
                                                        if(isset($_GET["fecha"]) && $_GET["fecha"] == $i)
                                                        {
                                                            // suplanto el lugar donde estaba la fecha por la selección default
                                                            echo "<option value=''>Seleccionar Año de Salida</option>";
                                                        }
                                                        else{
                                                            echo "<option value='" . $i . "'>" . $i . "</option>";
                                                        }
                                                    };
                                                    
                                                    ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-3" style="margin-top:22px">
                                    <div class="row justify-content">
                                        <div class="col-md-2" style="margin-right:10px">
                                            <button class="btn btn-primary" form="form" type="submit">Filtrar</button>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-warning" onclick="window.location.href = 'index.php'">Limpiar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if(empty($listado_juegos) && isset($_GET["fecha"])) : ?>
                                <div>
                                    <h3>No hay registros de juego para ese Año</h3>
                                </div>
                            <?php else : ?>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Título</th>
                                            <th style="width: 15%;">Fecha de Salida</th>
                                            <th style="width: 40%;">Descripción</th>
                                            <th style="width: 35%;">Portada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach($listado_juegos as $juego): ?>
                                        <tr>
                                            <td>
                                                <p>
                                                    <a href="/Proyecto_2/LK-Games/public/Pages/game.php?id=<?php echo $juego->getId_game()?>"><i class="fas fa-search" style="cursor:pointer"></i></a>
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
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>

            <?php require __DIR__ . '/Pages/Partials/footer.php'; ?>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
</body>


</html>