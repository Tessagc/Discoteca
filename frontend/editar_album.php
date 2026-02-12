<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar el album</title>
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
            if (isset($_GET['cod_album'])) {
                try {
                    @require("../backend/conexion_discoteca.php");

                    // consulta a BBDD
                    @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                    mysqli_set_charset($conexion, "utf8mb4");
                    
                    // recoger datos album
                    $cod_album = $_GET['cod_album'];
                    $consulta = "SELECT * FROM albumes WHERE cod_album = $cod_album;";
                    $respuesta = mysqli_query($conexion, $consulta);
                    $album = mysqli_fetch_array($respuesta);

                    // campos 
                    echo "<h2 class='text-primary text-center text-shadow-blue my-3'>Actualizar datos del album ".$album['titulo']."</h2>";

                    // campo oculto codigo
                    echo "<form action='../backend/actualizar_album.php' class='container p-5' name='formulario' method='post' enctype='multipart/form-data'>
                        <input type='hidden' name='cod_album' value='".$_GET['cod_album']."'>
                        <label for='titulo_album' class='form-label fs-4 fw-bold text-primary'>Titulo del album: </label>
                        <input type='text' name='titulo_album' required id='titulo_album' value='".$album['titulo']."'class='form-control mb-3 border-info'>

                        <label for='fecha_album' class='form-label fs-4 fw-bold text-primary'>Año de lanzamiento: </label>
                        <input type='number' name='fecha_album' min='1900' max='2026' required id='fecha_album' value=".$album['fecha']." class='form-control mb-3 border-info'>
                        ";

                        // recoger grupos
                        $consulta2 = "SELECT * FROM grupos ORDER BY nombre ASC;";
                        $grupos = mysqli_query($conexion, $consulta2);
                        echo "<label for='grupo_album' class='form-label fs-4 fw-bold text-primary'>Grupo del album: </label>
                            <select name='grupo_album' required id='grupo_album' class='form-select mb-3 border-info'>";
                            while ($grupo = mysqli_fetch_array($grupos)) {
                            if ($grupo['cod_grupo'] == $album['cod_grupo']) {
                                echo "<option value='".$grupo['cod_grupo']."' selected>".$grupo['nombre']."</option>";
                            } else {
                                echo "<option value='".$grupo['cod_grupo']."'>".$grupo['nombre']."</option>";
                            } 
                        }
                        echo "</select>";
                        
                        echo "<label for='portada_album' class='form-label fs-4 fw-bold text-primary'>Portada del album(Opcional: </label>
                        <input type='file' name='portada_album' id='portada_album'class='form-control mb-3 border-info'>";

                        mysqli_close($conexion);

                } catch (mysqli_sql_exception $sql) {
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudieron obtener los datos.</p>";
                }
            } else {
                header("location:ver_albumes.php?error=6");
                exit();
            }      
            ?>
            <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" name="enviar">Enviar</button>
                    <button type="reset" class="btn btn-secondary">Borrar</button>
                </div>
        </form>

    </main>
    <footer>

    </footer>
</body>
</html>