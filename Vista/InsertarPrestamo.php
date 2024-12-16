<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/VerClientesAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/InsertarPrestamo.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/InsertarPrestamo.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";   
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
        <link rel="stylesheet" href="../Estilos/EstilosInsertarPrestamo.css" >
        <!-- Estilos adicionales -->

    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center mt-3">    
                <div class="col-md-6 cen" >
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/InterfazAdministrador.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Insertar Prestamo.</p>
                        </div>

                </div>
            </div>

            <!-- Título de la página -->
            <h2  style="margin-top: 2em;" class="text-center mb-4">Nuevo Deseo Combiano</h2>

            <!-- Formulario de registro -->
            <div class="card">
                <div class="card-body">
                    <form action="../Controlador/ProcesarPrestamo.php" method="POST" onsubmit="return confirmarRegistro()" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="nombreUsuario">Monto a Prestar</label>
                            <input type="number" class="form-control" id="monto" name="monto" >
                        </div>

                        <div style="padding-top: 1em;" class="form-group">
                            <label for="imagen" class="form-label">Subir Comprobante (Para pagos virtuales)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                <label class="custom-file-label" for="imagen">Selecciona un archivo...</label>
                            </div>
                        </div>                

                        <div style="padding-top: 1em;" class="form-check">
                            <input class="form-check-input" type="checkbox" value="" name="interesMensual" checked>
                            <input type="hidden" name="idUsuario2" value="<?php echo($_POST['idUsuario']) ?>">
                            <input type="hidden" name="credencialUsuario2" value="<?php echo($_POST['credencialUsuario']) ?>">
                            <label class="form-check-label" for="defaultCheck1">
                                Interes Mensual
                            </label>                
                        </div>    



                        <br>

                        <div style="padding-top: 1em;" class="form-group text-center">
                            <button type="submit" class="btn btn0 mr-3" name="Prestar">Prestar</button>
                            <button type="submit" class="btn btn2 mr-3" name="Volver">Volver</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>       

    <!-- Script para confirmar el registro -->
    <script>
                        function confirmarRegistro() {
                            return confirm("¿Estas seguro?");
                        }
                        document.addEventListener('DOMContentLoaded', function () {
                            const fileInput = document.querySelector('.custom-file-input');
                            const fileLabel = document.querySelector('.custom-file-label');

                            fileInput.addEventListener('change', function (event) {
                                const input = event.target;
                                const fileName = input.files[0] ? input.files[0].name : "Selecciona un archivo...";
                                fileLabel.textContent = fileName;
                            });
                        });

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
