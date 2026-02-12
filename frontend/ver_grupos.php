<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grupos</title>
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
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>Hubo un erro de conexion con la base de datos: </p>";
            }

            

            try {
                // conexin con BBDD
                @$conexion = mysqli_connect($servidor, $usuario, $contraseña, $bbdd);

                // consulta
                $consulta = "SELECT * FROM grupos ORDER BY nombre ASC";
                mysqli_set_charset($conexion, "utf8mb4");
                
                $grupos = mysqli_query($conexion, $consulta);

                echo "<h2 class='text-primary text-center text-shadow-blue mb-0'>Grupos </h2>";
                // errores de borrar grupo
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 0) { //borrado exitoso
                        echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success my-3'>Grupo borrado con exito.</p>";
                    } elseif ($_GET['error'] == 1) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo borrar el grupo.</p>";
                    } elseif ($_GET['error'] == 2) {
                        echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning my-3'>Debe elegir un grupo.</p>";
                    } elseif ($_GET['error'] == 3) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo actualizar el grupo.</p>";
                    } if ($_GET['error'] == 4) { //actualizado exitoso
                        echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success my-3'>Grupo actualizado con exito.</p>";
                    } elseif ($_GET['error'] == 5) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>La imagen no es valida o ya existe.</p>";
                    }
                }

                // enlace nuevo grupo
                echo "<a href='insertar_grupo.php' class='d-block text-center text-decoration-none fw-bold my-3'>
                Añadir un nuevo grupo.</a>";

                // grupos
                echo "<div class='container'>";
                    echo "<div class='row'>";
                while ($grupo = mysqli_fetch_array($grupos)) {
                    echo "<div class='col-6 col-md-4 col-xl-3'>";
                        echo "<section class='card h-100 p-3 text-center border-info'>";
                            echo "<img src='../media/img/grupos/".$grupo['foto']."' alt='".$grupo['nombre']."' class='card-img-top w-100 rounded mb-2'>";
                            echo "<h5 class='fw-bold'>".$grupo['nombre']."</h5>";
                            echo "<p>".$grupo['biografia']."</p>";
                            echo "<a href='editar_grupo.php?cod_grupo=".$grupo['cod_grupo']."' class='btn btn-secondary text-decoration-none'>Actualizar info del grupo</a>";
                            echo "<a href='ver_albumes.php?cod_grupo=".$grupo['cod_grupo']."&nombreGrupo=".$grupo['nombre']."' class='btn btn-primary my-2 text-decoration-none'>Ver albumes del grupo.</a>";
                            echo "<a title='Borrar ".$grupo['nombre']."' class='btn btn-danger my-2 text-decoration-none' onclick='borrarGrupo(".$grupo['cod_grupo'].", \"".$grupo['nombre']."\")'>Borrar el grupo.</a>";
                        echo "</section>";
                    echo "</div>"; 

                }
                echo "</div>"; 
                echo "</div>";
                mysqli_close($conexion);
            } catch (mysqli_sql_exception $sql) {
                //". $sql->getCode().":". $sql->getMessage()."
                echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger'>No se pudieron obtener los datos.</p>";
            }
        ?>
    </main>
    <footer>
        
    </footer>
</body>
</html>