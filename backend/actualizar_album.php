<?php

    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_albumes.php?error=7");
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            // datos album
            $cod_album = $_POST['cod_album'];
            $tituloAlbum = $_POST['titulo_album'];
            $fechaAlbum = $_POST['fecha_album'];
            $grupoAlbum = $_POST['grupo_album'];
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

            // formato imagen si existe
            if ($nombreArchivo != "") {
                if (($tipo == "image/jpeg" or $tipo == "image/png" or $tipo == "image/webp") and $size <= 302400) {
                    if (!file_exists("../media/img/albumes/".$nombreArchivo)) {
                        if (move_uploaded_file($archivo, $destino)) {
                            $portadaAlbum = $nombreArchivo;
                        }
                    } else {
                        header("location:../frontend/ver_albumes.php?error=9");
                        exit();
                    }
                } else {
                    header("location:../frontend/ver_albumes.php?error=9");
                    exit();
                }
            }
            

            // conexion a BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
            mysqli_set_charset($conexion, "utf8mb4");
            
            // actualizar el album 
            if ($portadaAlbum != "") {
                $consulta = "UPDATE albumes SET
                    titulo = '$tituloAlbum',
                    fecha = $fechaAlbum,
                    cod_grupo = $grupoAlbum,
                    portada = '$portadaAlbum'
                    WHERE cod_album = $cod_album;
                ";
            } else {
                $consulta = "UPDATE albumes SET
                    titulo = '$tituloAlbum',
                    fecha = $fechaAlbum,
                    cod_grupo = $grupoAlbum
                    WHERE cod_album = $cod_album;
                ";
            }

            mysqli_query($conexion, $consulta);
            

            mysqli_close($conexion);

            header("location:../frontend/ver_albumes.php?error=8");
            exit();

        } else {
            header("location:../frontend/ver_albumes.php?error=7");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/ver_albumes.php?error=7");
        exit();
    }
?>