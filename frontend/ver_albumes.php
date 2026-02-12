<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Albumes</title>
    <link rel="stylesheet" href="../css/discoteca.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/discoteca.js"></script>
</head>
<body>
    <header>
        <nav class='navbar navbar-expand-md navbar-dark bg-dark p-0 m-0'>
            <div class="container-fluid p-0">
                <div class="d-flex flex-wrap w-100 align-items-center">
                    <div class="col-sm-12 col-md-8 p-0 m-0">
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
    <main class='mt-1'>  
        <h1 class='display-4 text-center text-shadow-black fw-bold text-uppercase'>Discoteca de Teresa.</h1>
        <!-- sesion -->
        <?php
            require_once("../backend/sesion.php");

        ?>
        
        <?php
            try {
                // archivo de conexion
                @require("../backend/conexion_discoteca.php");
            } catch (Throwable $th) {
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>Hubo un erro de conexion con la base de datos:</p>";
            }


            // errores de asociar genero y borra album
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 0) { //asociacion exitosa
                    echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success'>Album y genero asociados correctamente.</p>";
                } elseif ($_GET['error'] == 1) {
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudo conectar a la base de datos.</p>";
                } elseif ($_GET['error'] == 2) {
                    //".$_GET['mensaje']."
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudo añadir la asociacion a la base de datos, Error.</p>";
                } elseif ($_GET['error'] == 3) {
                    echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning'>Debe insertar los datos.</p>";
                } elseif ($_GET['error'] == 4) {
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudo borrar el album.</p>";
                } elseif ($_GET['error'] == 5) { // album borrado
                    echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success'>Album borrado con exito.</p>";
                } elseif ($_GET['error'] == 6) { // se entro a borrar album
                    echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning'>Debe seleccionar un album.</p>";
                } elseif ($_GET['error'] == 7) { // error actualizar
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudo actualizar el album.</p>";
                } elseif ($_GET['error'] == 8) { // actualizacion exitosa de album
                    echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success'>Actualizacion del album exitosa.</p>";
                } elseif ($_GET['error'] == 9) { // Imagen no valida para actualizar
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>La imagen no es valida o ya existe.</p>";
                } 
            }
            
            
            try {
                // conexin con BBDD
                @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                mysqli_set_charset($conexion, "utf8mb4");

                // consulta(varia dependiendo de si se viene o no de grupos)
                if (isset($_GET['cod_grupo'])) {
                    $cod_grupo = $_GET['cod_grupo'];
                    $consulta = "SELECT * FROM albumes WHERE cod_grupo = $cod_grupo ORDER BY titulo ASC";
                } elseif (isset($_GET['cod_genero'])) {
                    $cod_genero = $_GET['cod_genero'];
                    $consulta = "SELECT * FROM albumes WHERE cod_album IN (SELECT cod_album FROM albumes_generos WHERE cod_genero = ".$cod_genero .") ORDER BY titulo ASC";
                } else {
                    $consulta = "SELECT * FROM albumes ORDER BY titulo ASC";
                }

                @$albumes = mysqli_query($conexion, $consulta);
                
                // consulta para obtener todos los generos
                $consulta2 = "SELECT * FROM generos WHERE cod_genero IN (SELECT cod_genero FROM albumes_generos)";

                @$generos = mysqli_query($conexion, $consulta2);


                
                // encabezado segun datos de albumes
                
                if (isset($_GET['nombreGrupo'])) {
                    echo "<h2 class='text-primary text-center text-shadow-blue mb-0'>Albumes de ".$_GET['nombreGrupo']."</h2>";
                } else {
                    echo "<h2 class='text-primary text-center text-shadow-blue mb-0'>Albumes </h2>";
                }

                
                // desplegable para filtrar por genero
                echo "<div class='d-flex align-items-center justify-content-center gap-1 my-3'>";
                echo "<div class='dropdown m-2'>
                    <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' >
                        Filtrar por Genero
                    </button>
                    <ul class='dropdown-menu'>";

                    // generos en el dropdown
                    while ($genero = mysqli_fetch_array($generos)) {
                        echo "<li><a class='dropdown-item' href='ver_albumes.php?cod_genero=".$genero['cod_genero']."'>".$genero['genero']."</a></li>";
                    }
                echo "</ul>
                </div>";


                // enlace para añadir un nuevo album
                echo "<a href='insertar_album.php' class='link-primary text-decoration-none fw-bold'>Añadir nuevo album</a>
                </div>";

                // albumes
                echo "<div class='container'>";
                    echo "<div class='row'>";
                while ($album = mysqli_fetch_array($albumes)) {
                    echo "<div class='col-6 col-md-4 col-xl-3'>";
                        echo "<section class='card h-100 p-3 text-center border-info'>";
                                echo "<img src='../media/img/albumes/".$album['portada']."' class='card-img-top w-100 rounded mb-2' alt='".$album['titulo']."'>";
                                echo "<h5 class='fw-bold'>".$album['titulo']."</h5>";
                                echo "<p>(".$album['fecha'].")</p>";
                                echo "<a href='ver_canciones.php?cod_album=".$album['cod_album']."&nombreAlbum=".$album['titulo']."' class='btn btn-primary my-2 text-decoration-none'>Ver canciones del album.</a>";
                                echo "<a href='editar_album.php?cod_album=".$album['cod_album']."' class='btn btn-secondary text-decoration-none'>Actualizar album.</a>";
                                echo "<a href='insertar_cancion.php?cod_album=".$album['cod_album']."&titulo=".$album['titulo']."' class='btn btn-success my-2 text-decoration-none'>Añadir canción al album.</a>";
                                echo "<a href='asociar_album_genero.php?cod_album=".$album['cod_album']."&titulo=".$album['titulo']."' class='btn btn-info my-2 text-decoration-none'>Asociar un genero al album.</a>";
                                echo "<a title='Borrar ".$album['titulo']."' onclick='borrarAlbum(".$album['cod_album'].", \"".$album['titulo']."\")' class='btn btn-danger my-2 text-decoration-none'>Borrar el album.</a>";
                            echo "</section>";
                        echo "</div>"; 
                }
                    echo "</div>"; 
                echo "</div>";
                @mysqli_close($conexion);
            } catch (mysqli_sql_exception $sql) {
                //". $sql->getCode().":". $sql->getMessage()."
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>Hubo un error de base de datos:</p>";
            }
            
        ?>

    </main>
    <footer>

    </footer>
</body>
</html>