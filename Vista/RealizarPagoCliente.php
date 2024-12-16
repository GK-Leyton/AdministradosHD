<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}

if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoCliente.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarPagos.php")) {
    //    echo "<h1>redirigido desde " . $_SESSION['PaginaAnterior'] . "</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/RealizarPagoCliente.php";
}

require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
$result = $consulta->ObtenerComprovanteDeudaPorIdDeuda($_POST['idDeuda']);
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
        <link rel="stylesheet" href="../Estilos/EstilosRealizarPagoCliente.css">
        <!-- Estilos adicionales -->
        <style>
            .imagen {
                display: block;
                margin: 0 auto; /* Centra la imagen horizontalmente */
                max-width: 100%; /* Asegura que la imagen no se desborde del contenedor */
                height: auto; /* Mantiene la relación de aspecto de la imagen */
            }
        </style>
    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div style="margin-bottom: 1.5em;" class="row justify-content-center mt-3">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/Interfazcliente.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Registro Pago.</p>
                        </div>
                    </nav>
                </div>
            </div>

            <?php
            if ($result->num_rows > 0) {
                $row = $consulta->obtenerDatosDeLasConsultas($result);
                ?>
                <img class="imagen" src="../ComprovantesDeuda/Aprovados/<?php echo $row['comprovante_deuda']; ?>.png" alt="Imagen">
                <?php
            } else {
                ?>
                <img class="imagen" src="../imagenes/No_Existente/Comprovante_no_Existente.png" alt="Imagen">
                <?php }
            ?>

            <!-- Título de la página -->

            <!-- Formulario de registro -->
            <form action="../Controlador/ProcesarPago.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="idDeuda2" value="<?php $valor1 = (isset($_POST['idDeuda'])) ? $_POST['idDeuda'] : null;
            echo ($valor1); ?>">
                <input type="hidden" value="<?php $valor2 = (isset($_POST['totalPagar'])) ? $_POST['totalPagar'] : null;
            echo ($valor2); ?>" name="totalPagar2">
                <input type="hidden" value="<?php $valor3 = (isset($_POST['totalIntereses'])) ? $_POST['totalIntereses'] : null;
                echo ($valor3); ?>" name="totalIntereses2">

<?php
if ($valor1 == $valor2 && $valor1 == $valor3 && $valor1 == null) {
    ?>
                    <script>
                        alert("Este Pago Sera invalidado <?php echo $_SESSION['PaginaAnteriorAuxiliar'] ?>");
                        window.location.href = "<?php echo $_SESSION['PaginaAnteriorAuxiliar'] ?>";
                    </script> 
    <?php
}
?>

                <div class="form-group">
                    <label for="montoPago">Monto del Pago</label>
                    <input type="number" class="form-control" id="montoPago" name="montoPago" required>
                </div>

                <div class="form-group">
                    <label for="imagen" class="form-label">Subir Comprobante (Para pagos virtuales)</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="imagen" name="imagen">
                        <label class="custom-file-label" for="imagen">Selecciona un archivo...</label>
                    </div>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn2 mr-3" name="confRegistro">Registrar</button>
                    <a href="DeudasActivasCliente.php" class="btn btn0">Volver</a>
                </div>
            </form>
        </div>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
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
