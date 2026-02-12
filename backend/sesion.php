<?php
    session_start();
    // comprobar logueo
    if (!$_SESSION['estado_log']) {
        session_destroy();
        header("location:../index.php");
        exit();
    }

    // tiempo expiracion sesion
    if ($_SESSION['tiempo_log'] + 1200 < time()) {
        session_destroy();
        header("location:../index.php?mensaje=caducada");
        exit();
    }
?>