<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/ConfirmarEditar.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/ConfirmarEditar.php";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Inicio de Sesión</title>
        <style>
            body{
                background: linear-gradient(to right, #ffffff, #e0e0e0);
            }
        </style>
        <!-- Bootstrap CSS -->
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosConfirmarEditar.css">
    </head>
    <body>
        <div class="container">

            <div class="row justify-content-center mt-3">
                <div class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Editar Informacion.</p>
                        </div>

                </div>

            </div>


            <div class="row justify-content-center mt-5">
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center">No dudamos que seas tu, mas sin embargo es importante verificar</h5>
                            <!-- Formulario -->
                            <form action="../Controlador/ProcesarConfirmarEditar.php" method="post">
                                <div class="form-group">

                                    <label for="usuario">Número de documento</label>
                                    <input type="password" class="form-control" id="documento" name="documento" required="">

                                    <label for="usuario">Palabra segura</label>
                                    <input type="password" class="form-control" id="palabraSegura" name="palabraSegura" required="">

                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn0" name="continuar" value="continuar">Continuar</button>                                    


                            </form>
                            <form action="../Controlador/ProcesarConfirmarEditar.php" method="post">
                                <button type="submit" class="btn btn2" name="volver" value="volver">Volver</button>
                        </div>        
                        </from>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
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
