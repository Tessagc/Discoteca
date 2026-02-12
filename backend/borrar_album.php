<?php
    try {
        // archivo de conexion
        require("conexion_discoteca.php");
    } catch (Throwable $th) {
        header("location:../frontend/ver_albumes.php?error=4");
        exit();
    }



    try {
        if (isset($_GET['cod_album'])) {
            
            // conexion 
            $conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);


            // consulta para borrar
            $consulta = "DELETE FROM albumes WHERE cod_album = ".$_GET['cod_album'].";";
            mysqli_query($conexion, $consulta);

            mysqli_close($conexion);

            header("location:../frontend/ver_albumes.php?error=5");
            exit();
        } else {
            header("location:../frontend/ver_albumes.php?error=4");
            exit();
        }
    } catch (mysqli_sql_exception $sql) {
        header("location:../frontend/ver_albumes.php?error=4");
        exit();
    }
?>