<?php
if (!isset($_SESSION)) {
    session_unset();
    session_start();
    $_SESSION['PaginaAnterior'] = "../Vista/Login.php";
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
        <link rel="stylesheet" href="../Estilos/EstilosLogin.css">      


    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center row-mt-2">
                <div style="margin-bottom: 6em" class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Notificación</p>                        
                        </div>

                </div>
            </div>
            <div class="row justify-content-center row-mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Iniciar Sesión</h5>
                        <!-- Formulario -->
                        <form action="../Controlador/ProcesarLogin.php" method="post">
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="usuario">
                            </div>
                            <div class="form-group">
                                <label for="contrasena">Contraseña</label>
                                <input type="password" class="form-control" id="clave" name="clave" placeholder="contraseña">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn0" name="Ingresar" value="Ingresar">Iniciar Sesión</button>
                                <button type="submit" class="btn btn1 btn-sm " name="Editar" value="Editar">Editar Datos</button>
                                <button type="submit" class="btn btn2" name="Registrar" value="Registrar">Registrarse</button>

                                <!-- Bootstrap JS and dependencies -->
                                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
                                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                                <script>
                                        var bootstrapTimeout = setTimeout(loadLocalBootstrap, 3000); // 3 seconds            
                                        function loadLocalBootstrap() {
                                            clearTimeout(bootstrapTimeout);
                                            var localBootstrap = document.getElementById('local-bootstrap');
                                            localBo otstrap.removeAttribute('disabled');
                                        }
                                        function clearBootstrapTimeout() {
                                            clearTimeout(bootstrapTimeout);
                                        }
                                </script>
                                </body>
                                </html>