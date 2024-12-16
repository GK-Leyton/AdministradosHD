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
if ((isset($_SESSION['PaginaAnterior'])) && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto_Predeterminadas.php") && ($_SESSION['PaginaAnterior'] != "../Vista/AgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarTerminarAgregarFoto.php")) {
    //echo "<h1>Redirigido a ".$_SESSION['PaginaAnterior']."</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/TerminarAgregarFoto_Predeterminadas.php";
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
        <link rel="stylesheet" href="../Estilos/EstilosTerminarAgregarFoto_Predeterminadas.css">
        <!-- Estilos adicionales -->
        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">    
    </head>
    <body>
        <div class="container">
            <!-- Logo de la empresa -->
            <div class="row justify-content-center row-mt-2">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Seleccionard Foto</p>
                        </div>
                </div>

            </div>

            <!-- Título de la página -->
            <h2 class="text-center mb-4">Datos Adicionales</h2>
            <div class="row justify-content-center">
                <div class="col-md-8 slogan">
                    <p style="text-align: center; font-family: var">¿Deseas Cargar una imagen tuya?.</p>
                </div>
            </div>

            <!-- Grid de fotos -->
            <form class="text-center mt-4" id="primer-formulario" method="post" action="../Controlador/ProcesarTerminarAgregarFoto.php">
                <div class="row photo-grid justify-content-center">
                    <?php for ($i = 1; $i <= 16; $i++): ?>
                        <div class="col-md-2 text-center">
                            <!-- Cambios aquí: agregar evento onclick para seleccionar radio -->
                            <img src="../FotosPerfil/Confirmadas/fotoPerfil<?php echo $i; ?>.png" alt="Foto <?php echo $i; ?>" class="rounded-pill"
                                 onclick="selectRadio('opcion<?php echo $i; ?>')">
                            <div>
                                <input class="form-check-input" type="radio" name="opcion" id="opcion<?php echo $i; ?>" value="fotoPerfil<?php echo $i; ?>" onchange="validateForm()">
                                <label class="form-check-label" for="opcion<?php echo $i; ?>">Perfil <?php echo $i; ?></label>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
                <button type="submit" class="btn btn0 mx-2 btn-block" name="cargarImagenPredeterminada">Cargar Imagen</button>
                <button type="submit" class="btn btn2 mx-2 btn-block" name="volver">Volver</button>
            </form>
        </div>

        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- JavaScript personalizado para seleccionar radio y validar formulario -->
        <script>
                                    function selectRadio(radioId) {
                                        document.getElementById(radioId).checked = true;
                                        validateForm();
                                    }

                                    function validateForm() {
                                        const radios = document.querySelectorAll('input[name="opcion"]');
                                        let selected = false;
                                        for (const radio of radios) {
                                            if (radio.checked) {
                                                selected = true;
                                                break;
                                            }
                                        }

                                        document.querySelector('button[name="cargarImagenPredeterminada"]').disabled = !selected;
                                    }

                                    document.addEventListener('DOMContentLoaded', function () {
                                        validateForm(); // Validate form on page load
                                    });


                                    document.addEventListener('DOMContentLoaded', function () {
                                        var scrollToBotBtn = document.getElementById('scrollToBotBtn');
                                        var scrollToTotBtn = document.getElementById('scrollToTopBtn');

                                        window.addEventListener('scroll', function () {
                                            if ((window.scrollY < 600) && (window.scrollY > 100)) {
                                                scrollToBotBtn.style.display = 'flex';
                                            } else {
                                                scrollToBotBtn.style.display = 'none';
                                            }

                                        });


                                        window.addEventListener('scroll', function () {
                                            if ((window.scrollY > 600)) {
                                                scrollToTopBtn.style.display = 'flex';
                                            } else {
                                                scrollToTopBtn.style.display = 'none';
                                            }

                                        });

                                        scrollToBotBtn.addEventListener('click', function () {
                                            window.scrollTo({
                                                top: document.body.scrollHeight,
                                                behavior: 'smooth'
                                            });
                                        });


                                        scrollToTopBtn.addEventListener('click', function () {
                                            window.scrollTo({
                                                top: 0,
                                                behavior: 'smooth'
                                            });
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

        <button id="scrollToBotBtn" title="Volver abajo">
            <i class="fa fa-arrow-down"></i>
        </button>


        <button id="scrollToTopBtn" title="Volver arriba">
            <i class="fa fa-arrow-up"></i>
        </button>       
    </body>
</html>