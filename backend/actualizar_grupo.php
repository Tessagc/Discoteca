<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_grupos.php?error=3");
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            // datos del grupo para actualizar
            $cod_grupo = $_POST['cod_grupo'];
            $nombreGrupo = $_POST['nombre_grupo'];
            $nacionalidadGrupo = $_POST['nacionalidad_grupo'];
            $biblio = $_POST['biblio_grupo'];
            $fotoGrupo = "";

            // revisar foto is existe
            if (!file_exists("../media/img/grupos")) {
                mkdir("../media/img/grupos", 0777);
            }

            $nombreArchivo = $_FILES['imagen_grupo']['name'];
            $archivo = $_FILES['imagen_grupo']['tmp_name'];
            $tipo = $_FILES['imagen_grupo']['type'];
            $size = $_FILES['imagen_grupo']['size'];
            $destino = "../media/img/grupos/". $nombreArchivo;

            if ($nombreArchivo != "") {
                if (($tipo == "image/jpeg" or $tipo == "image/png" or $tipo == "image/webp") and $size <= 302400) {
                    if (!file_exists("../media/img/grupos/".$nombreArchivo)) {
                        if (move_uploaded_file($archivo, $destino)) {
                            $fotoGrupo = $nombreArchivo;
                        }
                    } else {
                        header("location:../frontend/ver_grupos.php?error=5");
                        exit();
                    }
                } else {
                    header("location:../frontend/ver_grupos.php?error=5");
                    exit();
                }
            }

            // conexion a BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

            // preparar datos para consulta
            $nombreGrupo = mysqli_real_escape_string($conexion, $nombreGrupo);
            $nacionalidadGrupo = mysqli_real_escape_string($conexion,$nacionalidadGrupo);
            $biblio = mysqli_real_escape_string($conexion,$biblio);

            // actualizar el grupo
            if ($fotoGrupo != "") {
                $consulta = "UPDATE grupos SET
                    nombre = '$nombreGrupo',
                    nacionalidad = '$nacionalidadGrupo',
                    biografia = '$biblio',
                    foto = '$fotoGrupo'
                    WHERE cod_grupo = $cod_grupo;
                ";
            } else {
                
                $consulta = "UPDATE grupos SET
                    nombre = '$nombreGrupo',
                    nacionalidad = '$nacionalidadGrupo',
                    biografia = '$biblio'
                    WHERE cod_grupo = $cod_grupo;
                ";
            }

            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);
            

            header("location:../frontend/ver_grupos.php?error=4");
            exit();

        } else {
            header("location:../frontend/ver_grupos.php?error=3&hola=0");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        echo $sql->getMessage();
        header("location:../frontend/ver_grupos.php?error=3");
        exit();
    }
?>