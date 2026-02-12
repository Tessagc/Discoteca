<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canciones</title>
    <link rel="stylesheet" href="../css/discoteca.css">
    <script src="../js/bootstrap.js"></script>
    <script src="../js/discoteca.js"></script>
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
        <h1 class='display-4 text-center text-shadow-black text-shadow-grey fw-bold text-uppercase'>Discoteca de Teresa.</h1>
        <!-- sesion -->
        <?php
            require_once("../backend/sesion.php");
        ?>

        <?php
            try {
                // archivo de conexion
                @require("../backend/conexion_discoteca.php");
            } catch (Throwable $th) {
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>Hubo un error de conexion con la base de datos</p>";
            }


            // errores borrar cancion
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 0) { //asociacion exitosa
                    echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success my-3'>Cancion borrada correctamente.</p>";
                } elseif ($_GET['error'] == 1) {
                    echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo Borrar la cancion.</p>";
                } 
            }

            try {
                if (isset($_GET['cod_album'])) {
                    $cod_album = $_GET['cod_album'];
                    // conexin con BBDD
                    @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);
                    mysqli_set_charset($conexion, "utf8mb4");

                    // consultas
                    $consulta = "SELECT * FROM canciones WHERE cod_album = $cod_album ORDER BY titulo ASC";

                    $canciones = mysqli_query($conexion, $consulta);

                    echo "<h2 class='text-primary text-center text-shadow-blue my-3'>Canciones de ".$_GET['nombreAlbum']."</h2>";
                        echo "<ul class='list-group container my-2 align-items-center'>";
                        while ($cancion = mysqli_fetch_array($canciones)) {
                        echo "<li class='list-group-item d-flex justify-content-between align-items-center border border-info w-75'>";
                            echo "<div>";
                                echo "<strong>".$cancion['titulo']."</strong>";
                                echo "<p>Duracion: ".$cancion['duracion']."</p>";
                            echo "</div>";
                            
                            echo "<div>";
                                    echo "<a class='btn btn-sm btn-danger' title='Borrar ".$cancion['titulo']."' 
                                        onclick='borrarCancion(".$cancion['cod_cancion'].", \"".$cancion['titulo']."\" , \"".$_GET['cod_album']."\" , \"".$_GET['nombreAlbum']."\")'>
                                        Borrar canción
                                    </a>";
                            echo "</div>";
                        echo "</li>";
                    }

                    mysqli_close($conexion);
                } else {
                    header("location:ver_albumes.php");
                    exit();
                }
            } catch (mysqli_sql_exception $sql) {
                // ". $sql->getCode().":". $sql->getMessage()."
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudieron obtener los datos.</p>";
            }
        ?>
    </main>
    <footer>
        
    </footer>
    
</body>
</html>