<?php

require "../../../vendor/autoload.php";
use LKGames\Bussiness\UserBussiness;

    session_start();
    if ((empty($_SESSION['userID']) || is_null($_SESSION['userID'])) && empty($_SESSION['userPermissionsLVL']) || $_SESSION['userPermissionsLVL'] != 3) {
        session_destroy();
        header("Location: /Proyecto_2/LK-Games/public/Pages/login.php");
        exit();
    }


    $userBusiness = new UserBussiness();
    $user_list = $userBusiness->userAll();

?>


<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <title>LK Games - User Admin Menu</title>

    <link href="../../Styles/TemplateStyless/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> 
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link href="../../Styles/TemplateStyless/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../Styles/TemplateStyless/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body>

<!--Model de Edit-->
<div class="modal inmodal fade" id="editUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px">
            <div class="modal-header" style="background-color: #202D36; border-bottom: 5px solid #F7BB01; display: flex; justify-content: space-between; align-items: center; height: 45px;">
                <h4 style="color: white; margin: 0; font-size: large;" id="myModalLabel"> Editar Usuario</h4>
            </div>
            <div class="modal-body">
                <form id="userEditForm" action="userAdminMenuActions/edituser_validator.php" method="POST">
                    <input id="user_id" name="user_id" hidden />
                    <div>
                        <div class="row">
                            <div class="col-lg-6">
                                <h4><strong>Campos a editar</strong></h4>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4">
                                <h6><input type="checkbox" id="user_status" name="user_status" class="checkbox-modal" style="margin-top:0px;" />&nbsp;Activar Usuario </h6>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-md-5" style="margin:3px">
                                <label>
                                    <strong>Nombre</strong>
                                </label>
                                <input type="text" class="form-control" style="width: 270px;" id="user_name" name="user_name"/>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5" style="margin:3px">
                                <label>
                                    <strong>Email</strong>
                                </label>
                                <input type="text" class="form-control" style="width: 270px;" id="user_email" name="user_email"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5" style="margin:3px">
                                <label>
                                    <strong>Permisos</strong>
                                </label>
                                <select class="form-select" style="width: 270px;" id="user_permisos" name="user_permisos">
                                    <option value="1">Cliente</option>
                                    <option value="2">Soporte</option>
                                    <option value="3">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row" style="width: 100%">
                    <div class="col-md-3">
                        <div class="btn btn-outline-success" id="btnEditUser"> CONFIRMAR </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="btn btn-outline-danger" onclick="$('#editUser').modal('hide')"> CANCELAR </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Model de Delte-->
<div class="modal inmodal fade" id="deleteUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 600px">
            <div class="modal-header" style="background-color: #202D36; border-bottom: 5px solid #F7BB01; display: flex; justify-content: space-between; align-items: center; height: 45px;">
                <h4 style="color: white; margin: 0; font-size: large;" id="myModalLabel"> Confirmar Eliminación de Usuario</h4>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea eliminar al usuario con los siguientes detalles?</p>
                <form id="deleteUserForm" action="userAdminMenuActions/deleteuser_validator.php" method="POST">
                    <input type="hidden" id="user_delete_id" name="user_id_delete" />
                    <div class="form-group">
                        <label><strong>Nombre:</strong></label>
                        <input type="text" class="form-control" id="user_delete_name" readonly />
                    </div>
                    <div class="form-group">
                        <label><strong>Email:</strong></label>
                        <input type="text" class="form-control" id="user_delete_email" readonly />
                    </div>
                    <div class="form-group">
                        <label><strong>Permisos:</strong></label>
                        <input type="text" class="form-control" id="user_delete_permisos" readonly />
                    </div>
                    <div class="form-group">
                        <label><strong>Estado:</strong></label>
                        <input type="text" class="form-control" id="user_delete_status" readonly />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row" style="width: 100%">
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger" id="btnDeleteUser"> Eliminar </button>
                    </div>
                    <div class="col-lg-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> Cancelar </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="wrapper">

        <?php require __DIR__ . '../../../Pages/Partials/sideBar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <?php require __DIR__ . '../../../Pages/Partials/topBar.php'; ?>

                <div class="container-fluid">

                    <p class="mb-4">Desde aquí podras Editar y Eliminar los Usuarios que se hayan registrado!</p>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%;">Id</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 20%;">Email</th>
                                            <th style="width: 20%;">Permisos</th>
                                            <th style="width: 20%;">Estado</th>
                                            <th style="width: 10%;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($user_list as $user) : ?>
                                            <tr>
                                                <td>
                                                    <span id="user_id">
                                                        <?php echo $user->getId_user()?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span id="user_name">
                                                        <strong>
                                                            <?php echo $user->getName()?>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span id="user_email">
                                                        <strong>
                                                            <?php echo $user->getEmail()?>
                                                        </strong>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php
                                                        switch ($userBusiness->getPermissions($user->getId_user())) {
                                                            case 1:
                                                                echo '<span id="user_permission_1" class="btn btn-outline-primary" style="width:130px"> Cliente </span>';
                                                                break;
                                                            case 2:
                                                                echo '<span id="user_permission_2" class="btn btn-outline-warning" style="width:130px"> Soporte </span>';
                                                                break;
                                                            case 3:
                                                                echo '<span id="user_permission_3" class="btn btn-outline-info" style="width:130px"> Administrador </span>';
                                                                break;
                                                            default:
                                                                echo '<span id="user_permission_0" class="btn btn-outline-dark" style="width:130px"> Sin Asignar </span>';
                                                                break;
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                        if($user->getStatus()){
                                                            echo '<span id="user_status_1" class="btn btn-outline-success" style="width:130px">Activado</span>';
                                                        }
                                                        else{
                                                            echo '<span id="user_status_0" class="btn btn-outline-danger" style="width:130px">Desactivado</span>';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="btn btn-info btn-circle btn-sm edit-user-button" data-id="<?php echo $user->getId_user()?>" data-name="<?php echo $user->getName()?>" data-email="<?php echo $user->getEmail()?>" data-permisos="<?php echo $userBusiness->getPermissions($user->getId_user())?>" data-status="<?php echo $user->getStatus()?>">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </div>
                                                    <div class="btn btn-danger btn-circle btn-sm delete-user-button" data-deleteId="<?php echo $user->getId_user()?>" data-deleteName="<?php echo $user->getName()?>" data-deleteEmail="<?php echo $user->getEmail()?>" data-deletePermisos="<?php echo $userBusiness->getPermissions($user->getId_user())?>" data-deleteStatus="<?php echo $user->getStatus()?>">
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

            <?php require __DIR__ . '../../../Pages/Partials/footer.php'; ?>

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

        // al darle click a Editar
        // cargo la info de esa row en el modal
        // podiendo como por default su información
        var editUserButtons = document.querySelectorAll('.edit-user-button');
        editUserButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-id');
                var userName = this.getAttribute('data-name');
                var userEmail = this.getAttribute('data-email');
                var userPermisos = this.getAttribute('data-permisos');
                var userStatus = this.getAttribute('data-status');

                document.getElementById('user_id').value = userId;
                document.getElementById('user_name').value = userName;
                document.getElementById('user_email').value = userEmail;
                document.getElementById('user_permisos').value = userPermisos;
                document.getElementById('user_status').value = userStatus;

                var checkbox = document.getElementById('user_status');
                checkbox.checked = (userStatus === '1' || userStatus === 'true');

                var inputsToDisable = [
                    'user_name',
                    'user_email',
                    'user_permisos'
                ];

                if (userStatus === '0' || userStatus === 'false') {
                    inputsToDisable.forEach(function(inputId) {
                        document.getElementById(inputId).setAttribute('disabled', 'disabled');
                    });
                } else {
                    inputsToDisable.forEach(function(inputId) {
                        document.getElementById(inputId).removeAttribute('disabled');
                    });
                }

                $('#editUser').modal('show');
            });


        });

        // desactivar la posibilidad de editar campos si el usuario esta desactivado
        // que se actualice al darle click al check
        var activeUserCheckbox = $('#user_status');
        var userNameInput = $('#user_name');
        var userEmailInput = $('#user_email');
        var userPermisosInput = $('#user_permisos');
        activeUserCheckbox.on('change', function () {
            var isEnabled = activeUserCheckbox.is(':checked');
            userNameInput.prop('disabled', !isEnabled);
            userEmailInput.prop('disabled', !isEnabled);
            userPermisosInput.prop('disabled', !isEnabled);
            document.getElementById('user_status').value = isEnabled;
        });

        // envio de form
        var btnConfirmarUserEdit = document.getElementById('btnEditUser');
        btnConfirmarUserEdit.addEventListener('click', function() {
            document.getElementById('userEditForm').submit();
        });

        var deleteUserBTN = document.querySelectorAll('.delete-user-button');
        deleteUserBTN.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = this.getAttribute('data-deleteId');
                var userName = this.getAttribute('data-deleteName');
                var userEmail = this.getAttribute('data-deleteEmail');
                var userPermisos = this.getAttribute('data-deletePermisos');
                var userStatus = this.getAttribute('data-deleteStatus');

                document.getElementById('user_delete_id').value = userId;
                document.getElementById('user_delete_name').value = userName;
                document.getElementById('user_delete_email').value = userEmail;

                switch(userPermisos){
                    case "1":
                        document.getElementById('user_delete_permisos').value = "Cliente";
                        break;
                    case "2":
                        document.getElementById('user_delete_permisos').value = "Soporte";
                        break;
                    case "3":
                        document.getElementById('user_delete_permisos').value = "Administrador";
                        break;
                    default:
                        document.getElementById('user_delete_permisos').value = "Sin Asignar";
                        break;
                }

                if(userStatus){
                    document.getElementById('user_delete_status').value = "Activo";
                }
                else{
                    document.getElementById('user_delete_status').value = "Desactivado";
                }
                

                $('#deleteUser').modal('show');
            });
        });
        
        var btnConfirmarUserDelete = document.getElementById('btnDeleteUser');
        btnConfirmarUserDelete.addEventListener('click', function() {
            document.getElementById('deleteUserForm').submit();
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
        toastr.error("Error al editar, intentarlo más tarde");
    </script>';
    }
    if ($_GET["error"] == 2) {
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
        toastr.error("Error al Eliminar el usuario, intentelo más terde");
    </script>';
    }
}

if (isset($_GET["success"])) {
    if ($_GET["success"] == 1) {
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
        toastr.success("Usuario Editado");
    </script>';
    }
    if ($_GET["success"] == 2) {
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
        toastr.success("Usuario Eliminado");
    </script>';
    }
    
    
}
?>


</body>

</html>