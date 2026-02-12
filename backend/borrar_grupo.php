<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_grupos.php?error=1");
        exit();
    }



    try {
        if (isset($_GET['cod_grupo'])) {
            
            // conexion 
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);


            // consulta para borrar
            $consulta = "DELETE FROM grupos WHERE cod_grupo = ".$_GET['cod_grupo'].";";
            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);

            header("location:../frontend/ver_grupos.php?error=0");
            exit();
        } else {
            header("location:../frontend/ver_grupos.php?error=1");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/ver_grupos.php?error=1");
        exit();
    }
?>