<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir genero a un album</title>
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
            <?php
                if (isset($_GET['titulo'])) {
                    echo "<h2 class='text-primary text-center text-shadow-blue mb-0'>Añadir un genero al album ".$_GET['titulo']."</h2>";
                }
            ?>
            <form action="../backend/union_genero_album.php" name='formulario' method="post" enctype="multipart/form-data" class="container p-5">
                <label for="genero_album" class="form-label fs-4 fw-bold text-primary">Escoga un genero: </label>
                <?php
                    try {
                        // archivo de conexion
                        @require("../backend/conexion_discoteca.php"); 

                        // consulta a BBDD
                        @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                        mysqli_set_charset($conexion, "utf8mb4");
                        
                        // recoger generos
                        $consulta = "SELECT * FROM generos ORDER BY genero ASC;";
                        $generos = mysqli_query($conexion, $consulta);

                        echo "<select name='genero_album' required id='genero_album' class='form-select mb-3 border-info'>
                                <option value='' selected hidden>Seleccione un genero</option>";
                                while ($genero = mysqli_fetch_array($generos)) {
                                    echo "<option value='".$genero['cod_genero']."'>".$genero['genero']."</option>";
                                }
                        echo "</select>";

                    } catch (Throwable $th) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudieron mostrar los generos.</p>";
                    }

                    // campo oculto id album y titulo
                    echo "<input type='hidden' name='id_album' value='".$_GET['cod_album']."'>";
                    echo "<input type='hidden' name='titulo_album' value='".$_GET['titulo']."'>";

                    
                ?>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" name="enviar">Enviar</button>
                    <button type="reset" class="btn btn-secondary">Borrar</button>
                </div>
            </form>
            <p>¿No existe el genero? <a href="insertar_genero.php">Añadalo.</a></p>
        </div>
    </main>
    <footer>

    </footer>
</body>
</html>