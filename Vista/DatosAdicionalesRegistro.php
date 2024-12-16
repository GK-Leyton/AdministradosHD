<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DatosAdicionalesRegistro.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}


$_SESSION['PaginaAnterior'] = "../Vista/DatosAdicionalesRegistro.php";
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
        <link rel="stylesheet" href="../Estilos/EstilosDatosAdicionalesRegistro.css">
        <!-- Estilos adicionales -->

    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center mt-3">
                <div class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Actualizar Datos.</p>
                        </div>

                </div>

            </div>

            <!-- Título de la página -->
            <h2 style="padding-bottom: 0.5em; padding-top: 1em;" class="text-center mb-4">Datos Adicionales</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 slogan">
                    <p style="text-align: center; font-family: var">¿Como te identificamos?.</p>
                </div>
            </div>    
            <!-- Formulario de registro -->
            <div class="card">
                <div class="card-body">

                    <form action="../Controlador/ProcesarDatosAdicionalesRegistro.php" method="POST">
                        <div class="form-group">
                            <label for="cedula">Cedula</label>
                            <input type="text" class="form-control" id="cedula" name="cedula" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                </div>



                <div class="form-group text-center">
                    <button type="submit" class="btn btn0 mr-3" name="Registrar">Registrar</button>
                    <a href="../Vista/Login.php" class="btn btn2">Volver</a>
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
