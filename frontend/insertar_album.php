<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar nuevo album</title>
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
        <div class='container my-5'>
            <h1 class='display-4 text-center text-shadow-black fw-bold text-uppercase'>Discoteca de Teresa.</h1>
            <!-- sesion -->
            <?php
                require_once("../backend/sesion.php");

            ?>
            <h2 class='text-primary text-center text-shadow-blue my-3'>Insertar Nuevo album</h2>

            <!-- mensajes de error -->
            <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 0) {
                        echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success my-3'>Album añadido correctamente.</p>";
                    } elseif ($_GET['error'] == 1) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo acceder a la base de datos.</p>";
                    } elseif ($_GET['error'] == 2) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo añadir el album a la base de datos ".$_GET['mensaje'].".</p>";
                    } elseif ($_GET['error'] == 3) {
                        echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning my-3'>Formato de imagen invalido.</p>";
                    } elseif ($_GET['error'] == 4) {
                        echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning my-3'>La imagen ya existe.</p>";
                    } elseif ($_GET['error'] == 5) {
                        echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning my-3'>Debe añadir datos.</p>";
                    } 
                }
            ?>
            <form action="../backend/añadir_album.php" name='formulario' method="post" class="container p-5" enctype="multipart/form-data">
                <label for="titulo_album" class='form-label fs-4 fw-bold text-primary'>Titulo del album: </label>
                <input type="text" class="form-control mb-3 border-info" name="titulo_album" required id='titulo_album'>

                <label for="fecha_album" class="form-label fs-4 fw-bold text-primary">Año de lanzamiento: </label>
                <input type="number" name="fecha_album" class='form-control mb-3 border-info' min='1900' max='2026' required id='fecha_album'>

                
                <?php
                    try {
                        @require("../backend/conexion_discoteca.php");

                        // consulta a BBDD
                        @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                        mysqli_set_charset($conexion, "utf8mb4");
                        
                        // recoger grupos
                        $consulta = "SELECT * FROM grupos ORDER BY nombre ASC;";
                        $grupos = mysqli_query($conexion, $consulta);
                        echo "<label for='grupo_album' class='form-label fs-4 fw-bold text-primary'>Grupo del album: </label>
                            <select name='grupo_album' required id='grupo_album' class='form-select mb-3 border-info'>
                                <option value='' selected hidden>Seleccione un grupo</option>";
                        while ($grupo = mysqli_fetch_array($grupos)) {
                            echo "<option value='".$grupo['cod_grupo']."'>".$grupo['nombre']."</option>";
                        }
                        echo "</select>";

                        // recoger generos
                        $consulta2 = "SELECT * FROM generos ORDER BY genero ASC;";
                        $generos = mysqli_query($conexion, $consulta2);

                        echo "<label for='genero_album' class='form-label fs-4 fw-bold text-primary'>Genero del album: </label>
                            <select name='genero_album' required id='genero_album' class='form-select mb-3 border-info'>
                                <option value='' selected hidden>Seleccione un genero</option>";
                                while ($genero = mysqli_fetch_array($generos)) {
                                    echo "<option value='".$genero['cod_genero']."'>".$genero['genero']."</option>";
                                }
                        echo "</select>";


                    } catch (Throwable $th) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudieron mostrar los grupos/generos.</p>";
                    }
                ?>
                <label for="portada_album" class="form-label fs-4 fw-bold text-primary">Portada del album: </label>
                <input type="file" name="portada_album" required id='portada_album' class="form-control mb-4 border-info">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" name="enviar">Enviar</button>
                    <button type="reset" class="btn btn-secondary">Borrar</button>
                </div>
            </form>
            <p class="mt-3">¿No existe el grupo? <a href="insertar_grupo.php">Añadalo.</a></p>
            <p>¿No existe el genero? <a href="insertar_genero.php">Añadalo.</a></p>

        </div>
    </main>
    <footer>

    </footer>
</body>
</html>