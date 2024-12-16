<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarConfirmarEditar.php") && ($_SESSION['PaginaAnterior'] != "../Vista/ActualizarDatos.php") && ($_SESSION['PaginaAnterior'] != "../Vista/PerfilUsuario.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/ActualizarDatos.php";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Inicio de Sesión</title>
        <!-- Bootstrap CSS -->
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosActualizarDatos.css">

        <script>
            // Esta función se llama cuando el campo 'correo' cambia
            function desbloquearCorreo2() {
                // Obtener el valor del campo 'correo'
                var correo = document.getElementById('correo').value;
                var palabra = document.getElementById('palabraSegura').value;
                var contrasena = document.getElementById('contrasena').value;

                // Obtener el campo 'correo2'
                var correo2 = document.getElementById('correo2');
                var palabra2 = document.getElementById('palabraSegura2');
                var contrasena2 = document.getElementById('contrasena2');
                // Si el campo 'correo' no está vacío, desbloquear 'correo2'
                if (correo !== '') {
                    correo2.disabled = false;
                    document.getElementById('correo2').style.backgroundColor = '#FFFFFF';
                } else {
                    // Si el campo 'correo' está vacío, bloquear 'correo2'
                    correo2.disabled = true;
                    document.getElementById('correo2').style.backgroundColor = '#FFEB80';
                }
                if (palabra !== '') {
                    palabra2.disabled = false;
                    document.getElementById('palabraSegura2').style.backgroundColor = '#FFFFFF';
                } else {
                    // Si el campo 'correo' está vacío, bloquear 'correo2'
                    palabra2.disabled = true;
                    document.getElementById('palabraSegura2').style.backgroundColor = '#FFEB80';
                }
                if (contrasena !== '') {
                    contrasena2.disabled = false;
                    document.getElementById('contrasena2').style.backgroundColor = '#FFFFFF';
                } else {
                    // Si el campo 'correo' está vacío, bloquear 'correo2'
                    contrasena2.disabled = true;
                    document.getElementById('contrasena2').style.backgroundColor = '#FFEB80';
                }
            }

            // Ejecutar la función al cargar la página para asegurar que 'correo2' esté correctamente bloqueado si 'correo' está vacío
            window.onload = function () {
                desbloquearCorreo2();
            };
        </script>

    </head>
    <body>



        <div class="container">

            <div class="row justify-content-center mt-3">
                <div class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Actualizar Datos.</p>
                        </div>

                </div>

            </div>


            <div class="row justify-content-center mt-5">
                <div class="col-md-6">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-center"> <?php echo (isset($_SESSION['nombreUsuario'])) ? $_SESSION['nombreUsuario'] : $_SESSION['nombre'] ?> inserta los nuevos datos</h5>
                            <div class="row-md-8 slogan">
                                <p style="text-align: center;"> <i> solo es nesesario ingresar los datos que copten tu interes </i></p>
                            </div>
                            <!-- Formulario -->
                            <form action="../Controlador/ProcesarActualizarDatos.php" method="post">
                                <div class="form-group">

                                    <label for="usuario">Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo" oninput="desbloquearCorreo2()" >

                                    <label for="usuario">Confirmar Correo</label>
                                    <input type="email" class="form-control" id="correo2" name="correo2" >

                                    <label for="usuario">Palabra segura</label>
                                    <input type="password" class="form-control" id="palabraSegura" name="palabraSegura" oninput="desbloquearCorreo2()">

                                    <label for="usuario">Confirmar Palabra segura</label>
                                    <input type="password" class="form-control" id="palabraSegura2" name="palabraSegura2" >

                                    <label for="usuario">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" oninput="desbloquearCorreo2()">

                                    <label for="usuario">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena2" name="contrasena2" >

                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn0" name="continuar" value="continuar">Continuar</button>                                    
                                    <button type="submit" class="btn btn2" name="volver" value="volver">Volver</button>
                                </div>
                            </form>
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
