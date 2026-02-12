<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_albumes.php?error=1");
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            // datos asociacion genero_album
            $idGenero = $_POST['genero_album'];
            $idAlbum = $_POST['id_album'];

            // conexion con BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

            $consulta = "INSERT INTO albumes_generos (cod_album, cod_genero) VALUES ('$idAlbum', '$idGenero')";

            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);

            header("location:../frontend/ver_albumes.php?error=0");
            exit();
        } else {
            header("location:../frontend/ver_albumes.php?error=3");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        $mensaje = urlencode($sql->getMessage());
        header("location:../frontend/ver_albumes.php?error=2&mensaje=".$mensaje."");
        exit();
    }
?>