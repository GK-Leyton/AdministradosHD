<?php
if (!isset($_SESSION)) {
    session_start();
}
$auxiliarRuta = $_SESSION['PaginaAnterior'];
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoAdmin.php")) {
//    echo "<h1>Redirigido a " . $_SESSION['PaginaAnterior'] . "</h1>";
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/RealizarPagoAdmin.php";
}
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
        <link rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosRealizarPagoAdmin.css">
        <!-- Estilos adicionales -->

    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center mt-3">
                <div style="padding-top: 1em;" class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/InterfazAdministrador.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Realizar Pago.</p>
                        </div>

                </div> 
            </div> 

            <!-- Título de la página -->
            <div  style="margin-top: 3em" class="card">
                <div class="card-body">
                    <h3 class="text-center mb-4">Nuevo Pago</h3>

                    <!-- Formulario de registro -->
                    <form id="registroForm" action="../Controlador/ProcesarPago.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="idDeuda2" value="<?php $valor1 = (isset($_POST['idDeuda'])) ? $_POST['idDeuda'] : null;
echo ($valor1); ?>">
                        <input type="hidden" value="<?php $valor2 = (isset($_POST['totalPagar'])) ? $_POST['totalPagar'] : null;
echo ($valor2); ?>" name="totalPagar2">
                        <input type="hidden" value="<?php $valor3 = (isset($_POST['totalIntereses'])) ? $_POST['totalIntereses'] : null;
echo ($valor3); ?>" name="totalIntereses2">

                        <?php
                        //echo "<h1>" . $valor1 . "</h1>";
                        //echo "<h1>" . $valor2 . "</h1>";
                        //echo "<h1>" . $valor3 . "</h1>";
                        if ($valor1 == $valor2 && $valor1 == $valor3 && $valor1 == null) {
                            ?>
                            <script>
                                alert("Este Pago Sera invalidado");
                                window.location.href = "<?php echo $auxiliarRuta ?>";
                            </script> 
    <?php
}
?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="montoPago">Monto del Pago</label>
                                <input type="number" class="form-control" id="montoPago" name="montoPago" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="imagen" class="form-label">Subir Comprobante</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                    <label class="custom-file-label" for="imagen">Selecciona un archivo...</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn0 mr-3" name="confRegistro" id="confRegistro">Registrar</button>
                            <a href="../Vista/DeudasActivasAdmin.php" class="btn btn2">Volver</a>
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
                    document.getElementById('registroForm').addEventListener('submit', function (event) {
                        if (!confirm('¿Estás seguro de que deseas registrar este pago?')) {
                            event.preventDefault();
                        }
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
                    
                    document.querySelector('.custom-file-input').addEventListener('change', function (e) {
    var fileName = document.getElementById("imagen").files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});

        </script>
    </body>
</html>
