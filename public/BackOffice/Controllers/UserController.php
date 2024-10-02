<?php



namespace LKGamesPublic\Controllers;
use LKGames\DataAccess\UserDao;
use LKGames\Config\DBConfig;
use LKGames\Entity\UserEntity;

class UserController extends UserDao
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = DBConfig::getConn();
    }

    public function getAll() : array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function edit(array $data,int $permisos, int $editID): UserEntity
    {
        // busco el usuario para comprobar que exista
        $user = $this->getUser($editID);
        if($user == null){
            header("Location: /Proyecto_2/LK-Games/public/Pages/404.php");
            exit;
        }

        // pregunto si su id_permisos es difente a permisos (si es diferente se modifica)
        if($this->getPermissions($editID) != $permisos && $permisos != 0) {
            $result = $this->editPermissionsUser($editID, $permisos);
            if(!$result){
                header("Location: /Proyecto_2/LK-Games/public/BackOffice/Admin/userAdminMenu.php?error=1");
                exit;
            }
        }
        // editar los datos del usuario
        $qry = "UPDATE user SET ";
        foreach($data as $key => $value){
            $qry = $qry . " $key = :$key, ";
        }
        $qry = rtrim($qry,", ") . " Where id_user = $editID";
        $stmt = $this->pdo->prepare($qry);

        $execute = [];
        foreach ($data as $key => $value) {
            $execute[":$key"] = $value;
        }

        $stmt->execute($execute);

        $data['id_user'] = $editID;
        $data['nombre'] = $this->getUser($editID)->getName();
        $data['email'] = $this->getUser($editID)->getEmail();

        return $this->hydrate($data);
    }

    public function delete(int $id): bool
    {
        // elimino el registro del permiso que tenia el usuario
        $stmt = $this->pdo->prepare('DELETE FROM r_user_permissions WHERE id_user = :id');
        $stmt->execute([
            ':id' => $id
        ]);
        
        $stmt2 = $this->pdo->prepare('DELETE FROM user WHERE id_user = :id');
        $stmt2->execute([
            ':id' => $id
        ]);

        $rowsAffected = $stmt2->rowCount();
        if ($rowsAffected > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function login(String $name, String $pass): ?UserEntity
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE nombre = :user_name');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute([
            ':user_name' => $name,
        ]);

        $resultado = $stmt->fetch();

        // Si la verificación es exitosa, devuelve el usuario
        if ($resultado && password_verify(trim($pass), $resultado->getPassword())) {
            return $resultado;
        } else {
            return null; // Contraseña incorrecta o Usuario incorrecto
        }
    }


    public function register(String $name, String $pass, String $email): bool
    {
        // Verificar si no existe un usuario ya existente con esos datos
        if ($this->validateRegister($name, $email)) {
            // Si existe, retorno false (error)
            return false;
        } else {
            // Si no existe
            // Hash de la contraseña
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

            // Preparar los datos para la inserción
            $data = [
                "nombre" => $name,
                "email" => $email,
                "password" => $hashed_password // Guardar el hash de la contraseña
            ];

            // Construir la consulta SQL
            $qry = "INSERT INTO user (nombre, email, password, status) VALUES (:nombre, :email, :password, 1)";
            $stmt = $this->pdo->prepare($qry);

            // Ejecutar la consulta con los datos
            $stmt->execute($data);

            // Verificar que el insert sea OK
            $id = $this->pdo->lastInsertId();
            $user = $this->getUser($id);
            
            if ($user != null) {
                // Insert exitoso, devuelve true
                // le coloco el permiso de cliente de forma pre defidinida
                $user_id = $user->getId_user();
                $pQry = "INSERT INTO r_user_permissions (id_permissions, id_user) VALUES (1,:id)";
                $stmt = $this->pdo->prepare($pQry);
                $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
                $stmt->execute([
                    ':id' => $user_id,
                ]);
                $stmt->fetch();

                return true;
            } else {
                // Si no se pudo obtener el usuario después del insert, devuelve false
                return false;
            }
        }
    }

    private function validateRegister(String $name, String $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `user` WHERE nombre = :user_name OR email = :user_email');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute([
            ':user_name' => $name,
            ':user_email' => $email
        ]);

        $resultado = $stmt->fetch();

        if ($resultado === false) {
            // no existe
            return false;
        } else {
            // existe
            return true;
        }
    }

    public function getPermissions(int $id): ?int
    {
        if($id != null){
            $stmt = $this->pdo->prepare('SELECT id_permissions FROM r_user_permissions WHERE id_user = :id');
            $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
            $stmt->execute([
                ':id' => $id
            ]);

            $resultado = $stmt->fetch();

            if ($resultado == false) {
                // como es usuario nuevo le agrego el persimo de usuario
                return $this->setPermissionsUser($id);
            } else {
                return $resultado->getPermissions();
            }
        }
        return null;
    }

    private function getUser(int $id) : ?UserEntity
    {
        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id_user = :id');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute([
            ':id' => $id
        ]);
        
        $resultado = $stmt->fetch();
        
        if ($resultado == false) {
            return null;
        } else {
            return $resultado;
        }
    }

    private function setPermissionsUser(int $id, int $permisos=1) : int
    {
        $stmt = $this->pdo->prepare('INSERT INTO r_user_permissions (id_permissions, id_user) VALUES (:permisos, :id)');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute([
            ':id' => $id,
            ':permisos' => $permisos
        ]);
        
        $resultado = $stmt->fetch();
        
        if ($resultado == false) {
            return 0; // error al crear registro
        } else {
            return $resultado->getPermissions(); // devuelvo su nivel de permisos
        }
    }

    private function editPermissionsUser(int $id, int $permisos): bool
    {   

        $stmt = $this->pdo->prepare('UPDATE r_user_permissions SET id_permissions = :permisos WHERE id_user = :id');
        $stmt->execute([
            ':id' => $id,
            ':permisos' => $permisos
        ]);

        $rowsAffected = $stmt->rowCount();

        if ($rowsAffected > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function editPassUser(int $id, String $pass, String $newPass){

        $stmt = $this->pdo->prepare('SELECT * FROM user WHERE id_user = :id');
        $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
        $stmt->execute([
            ':id' => $id
        ]);

        $resultado = $stmt->fetch();

        // Si la verificación es correcta, devuelve el usuario
        if ($resultado && password_verify(trim($pass), $resultado->getPassword())) {
            
            if($pass == $newPass){
                // la contraseña nueva debe de ser diferente a la actual
                header("Location: /Proyecto_2/LK-Games/public/BackOffice/User/cambiarPass.php?error=2");
                exit;
            }

            $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);

            $sql = "UPDATE user SET password = :newpass WHERE id_user = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, UserEntity::class);
            $stmt->execute([
                ':id' => $id,
                ':newpass' => $hashed_password
            ]);
            

            $rowsAffected = $stmt->rowCount();

            if ($rowsAffected > 0) {
                // Contraseña Actualizada / que se vuelva a logear
                header("Location: /Proyecto_2/LK-Games/public/BackOffice/Validators/closeSession.php");
                exit;
            } else {
                // fallo al actualizar la contraseña
                header("Location: /Proyecto_2/LK-Games/public/BackOffice/User/cambiarPass.php?error=3");
                exit;
            }

        } else {
            // ingrese su contraseña actual
            header("Location: /Proyecto_2/LK-Games/public/BackOffice/User/cambiarPass.php?error=1");
            exit;
        }
    }
}
