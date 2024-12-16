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
if ((isset($_SESSION['PaginaAnterior'])) && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Vista/AgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarTerminarAgregarFoto.php")) {
    //echo "<h1>Redirigido a ".$_SESSION['PaginaAnterior']."</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/TerminarAgregarFoto.php";
}
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";

$imagenCargada = false;

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $nombre_original = $_FILES['imagen']['name'];
    $extension = '.png';
    $nombre_archivo = "fotoPerfil" . $_SESSION['idUsuario'] . $extension;
    $directorio_destino = "../FotosPerfil/NoConfirmadas/" . $nombre_archivo;

    $_SESSION['nombreImagen'] = $nombre_archivo;
    $_SESSION['directorioActual'] = $directorio_destino;

    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_destino)) {
        $imagenCargada = true;
        $_SESSION['imagenCargada'] = true;
        echo "<script>alert('Imagen Cargada con éxito');</script>";
    } else {
        echo "<script>alert('Ocurrió un error con el formato del archivo');</script>";
    }
} else {
    $imagenCargada = false;
}
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
        <link rel="stylesheet" href="../Estilos/EstilosTerminarAgrefarFoto.css">
        <!-- Estilos adicionales -->

    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center row-mt-2">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Agregar Foto</p>
                        </div>
                </div>

            </div>

            <!-- Formulario centrado verticalmente -->
            <div class="row main-content">
                <div class="col-md-6 offset-md-3">
                    <h2 class="text-center mb-4">Datos Adicionales</h2>
                    <p class="text-center">Carga una imagen para tu perfil.</p>

                    <?php
                    if ($imagenCargada) {
                        $_SESSION['auxImagenCargada'] = true;
                        ?>

                        <div class="">
                            <div class="text-center">
                                <img src="../FotosPerfil/NoConfirmadas/fotoPerfil<?php echo $_SESSION['idUsuario']; ?>.png" class="rounded-pill" alt="Foto de perfil" style="width: 150px;">
                            </div>
                        </div>
                        <br>
                        <br>
                    <?php
                    } else {
                        $_SESSION['auxImagenCargada'] = false;
                        ?>
                        <p class="text-center">Toma una foto linda.</p>

<?php }; ?>

                    <form id="formulario-imagen" method="post" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="imagen" class="form-label">Subir Imagen</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagen" name="imagen" required>
                                <label class="custom-file-label" for="imagen">Selecciona un archivo...</label>
                            </div>
                        </div>
                    </form>

                    <form id="segundo-formulario" method="post" action="../Controlador/ProcesarTerminarAgregarFoto.php" enctype="multipart/form-data">
                        <button type="submit" class="btn btn0 btn-block" id="cargarImagen" name="cargarImagen" disabled>Cargar Imagen</button>
                        <button type="submit" class="btn btn2 btn-block" name="volver">Volver</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Script para cambiar el texto del archivo seleccionado y enviar formulario -->
        <script>
        $(document).ready(function () {
            // Cambiar texto del archivo seleccionado
            $('.custom-file-input').on('change', function () {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
                // Enviar formulario al seleccionar una imagen
                $('#formulario-imagen').submit();
            });

            // Habilitar el segundo formulario si hay una imagen cargada
<?php if ($imagenCargada): ?>
                $('#cargarImagen').prop('disabled', false);
<?php endif; ?>
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
