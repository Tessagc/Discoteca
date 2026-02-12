<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/insertar_grupo.php?error=1");
        exit();
    }


    try {
        if (isset($_POST['enviar'])) {
            // datos nuevo grupo
            $nombreGrupo = $_POST['nombre_grupo'];
            $nacionalidadGrupo = $_POST['nacionalidad_grupo'];
            $biblio = $_POST['biblio_grupo'];
            $fotoGrupo = "";

            // revisar foto
            if (!file_exists("../media/img/grupos")) {
                mkdir("../media/img/grupos", 0777);
            }

            $nombreArchivo = $_FILES['imagen_grupo']['name'];
            $archivo = $_FILES['imagen_grupo']['tmp_name'];
            $tipo = $_FILES['imagen_grupo']['type'];
            $size = $_FILES['imagen_grupo']['size'];
            $destino = "../media/img/grupos/". $nombreArchivo;

            // formato imagen y comprobacion de existencia
            if (($tipo == "image/jpeg" or $tipo == "image/png" or $tipo == "image/webp") and $size <= 302400) {
                if (!file_exists("../media/img/grupos/".$nombreArchivo)) {
                    if (move_uploaded_file($archivo, $destino)) { // crear imagen
                        $fotoGrupo = $nombreArchivo;
                    }
                } else {
                    header("location:../frontend/insertar_grupo.php?error=5 ");
                    exit();
                }
            } else {
                header("location:../frontend/insertar_grupo.php?error=4");
                exit();
            }

        } else {
            header("location:../frontend/insertar_grupo.php?error=3");
            exit();
        }

        
        
        // conectar a BBDD
        $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
        mysqli_set_charset($conexion, "utf8mb4");

        // preparar datos para consulta
        $nombreGrupo = mysqli_real_escape_string($conexion, $nombreGrupo);
        $nacionalidadGrupo = mysqli_real_escape_string($conexion,$nacionalidadGrupo);
        $biblio = mysqli_real_escape_string($conexion,$biblio);

        // consulta y cerrar conexion
        $consulta = "INSERT INTO grupos (nombre, nacionalidad, biografia, foto) VALUES ('$nombreGrupo', '$nacionalidadGrupo', '$biblio', '$fotoGrupo');";

        mysqli_query($conexion, $consulta);

        mysqli_close($conexion);

        header("location:../frontend/insertar_grupo.php?error=0");
        exit();

    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/insertar_grupo.php?error=2&mensaje=".$sql->getMessage()."");
        exit();
    }
?>