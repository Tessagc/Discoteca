<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar el grupo</title>
    <link rel="stylesheet" href="../css/discoteca.css">
</head>
<body>
    <header>
        <nav class='navbar navbar-expand-md navbar-dark bg-dark p-0 m-0'>
            <div class="container-fluid p-0">
                <div class="d-flex flex-wrap w-100 align-items-center">
                    <div class="col-sm-8 col-md-8 p-0 m-0">
                        <a href="ver_albumes.php" class='nav-brand m-0 p-0'>
                            <img src="../media/img/cabecera.jpg" class='img-fluid d-block w-100' alt="cabecera pagina">
                        </a>
                    </div>
                    <div class="col-sm-4 col-md-4 p-0 m-0 d-flex border border-4 border-dark">
                        <ul class="navbar-nav m-0 d-flex flex-row list-unstyled justify-content-around w-100 m-0 p-0">
                            <li class="nav-item">
                                <a href="ver_albumes.php" class=" fs-4 nav-link text-white link-info fs-6 fs-md-5">Albumes</a>
                            </li>
                            <li class="nav-item ms-1">
                                <a href="ver_grupos.php" class=" fs-4 nav-link text-white link-info fs-6 fs-md-5">Grupos</a>
                            </li>
                            <li class="nav-item ms-1">
                                <a href="../backend/salir.php" class=" fs-4 nav-link text-white link-info fs-6 fs-md-5">Cerrar Sesion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- sesion -->
        <?php
            require_once("../backend/sesion.php");
        ?>
        <div class='container my-5'>
            <h1 class='display-4 text-center text-shadow-black fw-bold text-uppercase'>Discoteca de Teresa.</h1>
            <?php
                if (isset($_GET['cod_grupo'])) {
                    try {
                        @require("../backend/conexion_discoteca.php");

                        // consulta a BBDD
                        @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                        mysqli_set_charset($conexion, "utf8mb4");

                        $cod_grupo = $_GET['cod_grupo'];
                        $consulta = "SELECT * FROM grupos WHERE cod_grupo = $cod_grupo;";
                        

                        // formulario
                        $grupo = mysqli_fetch_array(mysqli_query($conexion, $consulta));

                        echo "<h2 class='text-primary text-center text-shadow-blue mb-0'>Actualizar datos de ". $grupo['nombre'].".</h2>
                                <form action='../backend/actualizar_grupo.php' class='container p-5' name='formulario' method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='cod_grupo' value='".$_GET['cod_grupo']."'>

                                <label for='nombre_grupo' class='form-label fs-4 fw-bold text-primary'>Nombre del grupo: </label>
                                <input type='text' name='nombre_grupo' required id='nombre_grupo' value='".$grupo['nombre']."' class='form-control mb-3 border-info'>

                                <label for='nacionalidad_grupo' class='form-label fs-4 fw-bold text-primary'>Nacionalidad del grupo: </label>
                                <input type='text' name='nacionalidad_grupo' required id='nacionalidad_grupo'value='".$grupo['nacionalidad']."' class='form-control mb-3 border-info'>
                                
                                <label for='biblio_grupo' class='form-label fs-4 fw-bold text-primary'>Bibliografia del grupo: </label>
                                <textarea name='biblio_grupo' rows='5' placeholder='En un lugar de la mancha...' required id='biblio_grupo' class='form-control mb-3 border-info'>".$grupo['biografia']."</textarea>
                                
                                <label for='imagen_grupo' class='form-label fs-4 fw-bold text-primary'>Imagen del grupo (opcional): </label>
                                <input type='file' name='imagen_grupo'  id='imagen_grupo' class='form-control mb-3 border-info'>
                                
                                <div class='d-flex gap-2'>
                                    <button type='submit' class='btn btn-success' name='enviar'>Enviar</button>
                                    <button type='reset' class='btn btn-secondary'>Borrar</button>
                                </div>";

                         echo "</form>";
                    } catch (mysqli_sql_exception $sql) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudieron obtener los datos.</p>";
                    }
                } else {
                    header("location:ver_grupos.php?error=2");
                    exit();
                }

            ?>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>