<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nuevo Genero</title>
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
            <!-- errores -->
            <?php
                if (isset($_GET['error'])) {
                    if ($_GET['error'] == 0) {
                        echo "<p class='text-success fw-bold text-center w-25 mx-auto text-center border border-success my-3'>Genero añadido correctamente.</p>";
                    } else if ($_GET['error'] == 1) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo conectar a la base de datos.</p>";
                    } elseif ($_GET['error'] == 2) {
                        echo "<p class='text-danger fw-bold text-center w-25 mx-auto text-center border border-danger my-3'>No se pudo añadir el genero a la base de datos, Error".$_GET['mensaje'].".</p>";
                    } else if ($_GET['error'] == 3) {
                        echo "<p class='text-warning fw-bold text-center w-25 mx-auto text-center border border-warning my-3'>Debe añadir los datos del genero.</p>";
                    } 
                }
            ?>
            <h2 class='text-primary text-center text-shadow-blue mb-0'>Insertar Nuevo genero</h2 >
            <form action="../backend/añadir_genero.php" name='formulario' method="post" enctype="multipart/form-data" class="container p-5">
                <label for="nombre_genero" class="form-label fs-4 fw-bold text-primary">Nombre del genero: </label>
                <input type="text" name="nombre_genero" id="nombre_genero" class="form-control mb-4 border-info">

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success" name="enviar">Enviar</button>
                    <button type="reset" class="btn btn-secondary">Borrar</button>
                </div> 
            </form>

            
        </div>
    </main>
    <footer>
        
    </footer>
    
</body>
</html>