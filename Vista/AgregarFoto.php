<?php
if (!isset($_SESSION)) {
    session_start();
}
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if ((isset($_SESSION['PaginaAnterior'])) && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto_Predeterminadas.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarTerminarAgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Vista/AgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarDatosAdicionalesRegistro.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/CambioFoto.php")) {
    //echo "<h1>Redirigido a ".$_SESSION['PaginaAnterior']."</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/AgregarFoto.php";
}
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Agregar Foto</title>
        <!-- Bootstrap CSS -->
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosAgregarFoto.css">
        <!-- Estilos adicionales -->

    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div style="margin-top: 1em;" class="row justify-content-center row-mt-3">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Agregar Foto</p>
                        </div>
                </div>

            </div>
            <!-- Título de la página -->

            <div class="row justify-content-center">
                <div class="col-md-8 slogan">
                    <p style="text-align: center; font-family: var">¿Deseas Cargar una imagen tuya?.</p>
                </div>
            </div>    
            <!-- Formulario de registro -->
            <form class="text-center" method="post" action="../Controlador/ProcesarAgregarFoto.php">
                <button type="submit" class="btn btn0 btn-block mx-1" name="cargarImagen">Cargar Imagen</button>
                <button type="submit" class="btn btn1 btn-block mx-1" name="noCargarImangen">imagen predeterminada</button>
            </form>

<?php
if (isset($_SESSION['PaginaAnterior_Auxiliar']) && ($_SESSION['PaginaAnterior_Auxiliar'] == '../Vista/PerfilUsuario.php')) {
    ?>

                <form style="margin-top: 10px ;" class="text-center" method="post" action="../Vista/PerfilUsuario.php">                
                    <button style="border-radius: 5px" type="submit" class="btn btn2 btn-block mx-1 " name="noCargarImangen">Volver</button>
                </form>

    <?php
}
?>
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
