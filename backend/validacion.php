<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        echo "Mensaje: ". $th->getMessage();
        exit();
    }

    try {
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['enviar'])) {

            // datos enviados
            $usuarioSesion = trim($_POST['userSesion']);
            $contraSesion = trim($_POST['passSesion']);

            if (empty($usuarioSesion) || empty($contraSesion)) {
                header("location:../index.php?mensaje=faltan");
                exit();
            }


            // Conectar BBDD
           $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

           $usuarioSesion = mysqli_real_escape_string($conexion, $usuarioSesion);
           $contraSesion = mysqli_real_escape_string($conexion, $contraSesion);

           $consulta = "SELECT id_usuario, password_hash FROM usuarios WHERE usuario='$usuarioSesion';";

           $resultado = mysqli_query($conexion, $consulta);

           $info = mysqli_fetch_array($resultado);

           // comprobar si es el usuario
           if ($info && password_verify($contraSesion, $info['password_hash'])) {
                session_start();

                // datos de la sesion
                $_SESSION['usuario_log'] = $usuarioSesion;
                $_SESSION['estado_log'] = true ;// true = conectado, false = desconectado
                $_SESSION['tiempo_log'] = time();

                header("location:../frontend/ver_albumes.php");
                exit();
            } else {
                header("location:../index.php?mensaje=incorrecto");
                exit();
            }
            
        } else {
            header("location:../index.php?mensaje=inicio");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        echo "<p>Error nº: ". $sql->getCode()."</p>";
        echo "<p>Mensaje: ". $sql->getMessage()."</p>";
    }
?>