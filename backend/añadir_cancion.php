<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/insertar_cancion.php?error=1&cod_album=".$idAlbumCancion);
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            
            // datos cancion
            $tituloCancion = $_POST['titulo_cancion'];
            $duracionCancion = $_POST['duracion_cancion'];
            $pistaCancion = $_POST['pista_cancion'];
            $idAlbumCancion = $_POST['codigo_album'];

            // conexion a BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

            $consulta = "INSERT INTO canciones (titulo, duracion, num_pista, cod_album) 
            VALUES ('$tituloCancion', '$duracionCancion', '$pistaCancion', '$idAlbumCancion')";

            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);
            header("location:../frontend/insertar_cancion.php?error=0&cod_album=".$idAlbumCancion."&titulo=".$_POST['nombre_album']);
            exit();
        } else {
            header("location:../frontend/insertar_cancion.php?error=3&cod_album=".$idAlbumCancion."&titulo=".$_POST['nombre_album']);
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/insertar_cancion.php?error=2&titulo=".$_POST['nombre_album']."&cod_album=".$idAlbumCancion);
        exit();
        
    }
?>