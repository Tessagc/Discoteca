<?php

    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/insertar_album.php?error=1");
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            // datos album
            $tituloAlbum = $_POST['titulo_album'];
            $fechaAlbum = $_POST['fecha_album'];
            $grupoAlbum = $_POST['grupo_album'];
            $generoAlbum = $_POST['genero_album'];
            $portadaAlbum = "";

            // revision de imagen
            if (!file_exists("../media/img/albumes")) {
                mkdir("../media/img/albumes", 0777);
            }

            $nombreArchivo = $_FILES['portada_album']['name'];
            $archivo = $_FILES['portada_album']['tmp_name'];
            $tipo = $_FILES['portada_album']['type'];
            $size = $_FILES['portada_album']['size'];
            $destino = "../media/img/albumes/". $nombreArchivo;

            // formato imagen
            if (($tipo == "image/jpeg" or $tipo == "image/png" or $tipo == "image/webp") and $size <= 302400) {
                if (!file_exists("../media/img/albumes/".$nombreArchivo)) {
                    if (move_uploaded_file($archivo, $destino)) {
                        $portadaAlbum = $nombreArchivo;
                    }
                } else {
                    header("location:../frontend/insertar_album.php?error=4");
                    exit();
                }
            } else {
                header("location:../frontend/insertar_album.php?error=3");
                exit();
            }

            // conexion a BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

            // añadir album
            $consulta1 = "INSERT INTO albumes (titulo, fecha, cod_grupo, portada) VALUES ('$tituloAlbum', '$fechaAlbum','$grupoAlbum', '$portadaAlbum');";
            
            if (mysqli_query($conexion, $consulta1)) {
                $ultimoCodAlbum = mysqli_insert_id($conexion);
            }

            // asociar genero al album
            $consulta2 = "INSERT INTO albumes_generos (cod_album, cod_genero) VALUES ('$ultimoCodAlbum', '$generoAlbum');";
            mysqli_query($conexion, $consulta2);

            mysqli_close($conexion);

            header("location:../frontend/insertar_album.php?error=0");
            exit();

        } else {
            header("location:../frontend/insertar_album.php?error=5");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/insertar_album.php?error=2&mensaje=".$sql->getMessage()."");
        exit();
    }
?>