<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesion</title>
    <link rel="stylesheet" href="css/discoteca.css">
</head>
<body>
    <header>
        <?php
            if (isset($_GET['mensaje'])) {
                if ($_GET['mensaje'] == "inicio") {
                    echo "<h2 class='text-warning text-center'>Debe iniciar sesion</h2>";
                } elseif ($_GET['mensaje'] == "faltan") {
                    echo "<h2 class='text-danger text-center'>Faltan datos</h2>";
                } elseif ($_GET['mensaje'] == "incorrecto") {
                    echo "<h2 class='text-danger text-center'>Usuario y/o contraseña incorrectos</h2>";
                } elseif ($_GET['mensaje'] == "caducada") {
                    echo "<h2 class='text-danger text-center'>Tiempo de sesion finalizado</h2>";
                }
            }
        ?>
    </header>
    <main>
        <form action="backend/validacion.php" method='post' class='container' name='sesiones' enctype='application/x-www-form-urlencoded'>
            <div class='mb-3 container px-5 w-75'>
                <label for="userSesion" class='form-label fs-4 fw-bold'>Usuario: </label>
                <input type="email" class='form-control border-info' name="userSesion" id="userSesion" autofocus required>
            </div>
            <div class='mb-3 container px-5 w-75'>
                <label for="passSesion" class='form-label fs-4 fw-bold'>Contraseña: </label>
                <input type="password" class='form-control border-info' name="passSesion" id="passSesion" required minlength='8' maxlength='8'>
            </div>
            <div class='mb-3 container'>
                <div class='container d-flex justify-content-center'>
                    <input type="submit" value="Acceder" name='enviar' class='btn btn-primary m-1'>
                    <input type="reset" value="Borrar" class='btn btn-secondary m-1'>
                </div>
            </div>
        </form>
    </main>
    <footer>
        
    </footer>
</body>
</html>