<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}

if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/Registro.php")) {
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}

$_SESSION['PaginaAnterior'] = "../Vista/Registro.php";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registro de Usuario</title>
        <!-- Bootstrap CSS -->
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosRegistro.css">
        <!-- Estilos adicionales -->
    </head>
    <body>
        <div class="container mt-5">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0; color: black; font-weight: bold;">Registro de Usuario</p>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Título de la página -->


            <!-- Tarjeta de formulario -->
            <div class="card">
                <div class="card-body">
                    <form action="../Controlador/ProcesarRegistro.php" method="POST">
                        <div class="form-group">
                            <label for="nombreUsuario">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="credencialUsuario">Credencial de Usuario</label>
                            <input type="text" class="form-control" id="credencialUsuario" name="credencialUsuario" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena">Contraseña</label>
                            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
                        </div>
                        <div class="form-group">
                            <label for="contrasena2">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="contrasena2" name="contrasena2" required>
                        </div>
                        <div class="form-group">
                            <label for="palabraSegura">Palabra Segura</label>
                            <input type="text" class="form-control" id="palabra" name="palabra" required>
                        </div>                
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn0 mr-3" name="confRegistro">Registrar</button>
                            <a href="../Vista/Login.php" class="btn btn2">Volver al Inicio</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            var bootstrapTimeout = setTimeout(loadLocalBootstrap, 3000); // 3 seconds

            function loadLocalBootstrap() {
                clearTimeout(bootstrapTimeout);
                var localBootstrap = document.getElementById('local-bootstrap');
                localBootstrap.removeAttribute('disabled');
            }

            function clearBootstrapTimeout() {
                clearTimeout(bootstrapTimeout);
            }
        </script>
    </body>
</html>
