<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/insertar_genero.php?error=1");
        exit();
    }



    try {
        if (isset($_POST['enviar'])) {
            // nombre del genero
            $nombreGenero = $_POST['nombre_genero'];

            // conexion con BBDD
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

            $consulta = "INSERT INTO generos (genero) VALUES ('$nombreGenero');";

            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);

            header("location:../frontend/insertar_genero.php?error=0");
            exit();
        } else {
            header("location:../frontend/insertar_genero.php?error=3");
            exit();
        }
        
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/insertar_genero.php?error=2&mensaje=".$sql->getMessage());
        exit();
    }
?>