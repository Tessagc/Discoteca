<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_canciones.php?error=1&cod_album=".$_GET['cod_album']."&nombreAlbum=".$_GET['nombreAlbum']);
        exit();
    }



    try {
        if (isset($_GET['cod_cancion'])) { 
            // conexion 
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);


            // consulta para borrar
            $consulta = "DELETE FROM canciones WHERE cod_cancion = ".$_GET['cod_cancion'].";";
            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);

            header("location:../frontend/ver_canciones.php?error=0&cod_album=".$_GET['cod_album']."&nombreAlbum=".$_GET['nombreAlbum']);
            exit();
        } else {
            header("location:../frontend/ver_canciones.php?error=1&cod_album=".$_GET['cod_album']."&nombreAlbum=".$_GET['nombreAlbum']);
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/ver_canciones.php?error=1&cod_album=".$_GET['cod_album']."&nombreAlbum=".$_GET['nombreAlbum']);
        exit();
    }
?>