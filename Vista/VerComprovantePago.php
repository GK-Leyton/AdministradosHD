<?php
if (!isset($_SESSION)) {
    session_start();
}
$paginaAnterioAux = $_SESSION['PaginaAnterior'];
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php") && ($_SESSION['PaginaAnterior'] != "../Vista/MasInformacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasAdmin.php")) {
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/VerComprovantePago.php";
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Comprovante de Pago</title>
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosVerComprovantePago.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center row-mt-3">
                <div class="col-md-6">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <?php if (isset($_SESSION['TipoUsuario']) && $_SESSION['TipoUsuario'] == 0) { ?>
                            <a href="../Vista/Interfazcliente.php">
                            <?php } elseif (isset($_SESSION['TipoUsuario']) && $_SESSION['TipoUsuario'] == 1) {
                                ?>
                                <a href="../Vista/InterfazAdministrador.php">
                                <?php } ?>
                                <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                            </a>
                            <div class="slogan ml-auto">
                                <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Comprovante</p>
                            </div>
                    </nav>
                </div>
            </div>
            <div class="col align-content-center text-center">
                <br>
                <div class="comprovante">
                    <?php
                    require '../Modelo/ConsultasUsuarios.php';
                    $consulta = new consultasUsuario();
                    $result;

                    if ((isset($_POST['idDeuda'])) && !isset($_POST['paraPagos'])) {
                        $result = $consulta->ObtenerComprovantePorIdDeuda($_POST['idDeuda']);
                        if ($result->num_rows > 0) {
                            $row = $consulta->obtenerDatosDeLasConsultas($result);
                            echo ($row['comprovante_deuda'] != null) ? '<p>Este es tu Com2provante.</p>' : '<div class="slogan"><p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Parece que no existen comprovantes para esta deuda.</p></div>';
                            echo ($row['comprovante_deuda'] != null ) ? "<img src='../ComprovantesDeuda/Aprovados/" . $row['comprovante_deuda'] . ".png' alt='Comprovante' class='img-fluid mx-auto d-block' width='500'>" : "<img src='../imagenes/No_Existente/Comprovante_no_Existente.png' alt='Comprovante' class='img-fluid mx-auto d-block' width='500'>";
                        }
                    } else if ((isset($_POST['idPago']))) {
                        $result = $consulta->ObtenerInformacionPagoPorId($_POST['idPago']);
                        if ($result->num_rows > 0) {
                            $row = $consulta->obtenerDatosDeLasConsultas($result);
                            echo ($row['comprovante_pago'] != null) ? '<p>Este es tu Comprovante.</p>' : '<div class="slogan"><p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Parece que no existen comprovantes para este pago</p></div>';
                            echo ($row['comprovante_pago'] != null ) ? (($row['estado'] == 0) ? "<img src='../ComprovantesPago/Confirmados/" . $row['comprovante_pago'] . ".png' alt='Comprovante0' class='img-fluid mx-auto d-block' width='500'>" : (($row['estado'] == 1) ? "<img src='../ComprovantesPago/PorConfirmar/" . $row['comprovante_pago'] . ".png' alt='Comprovante1' class='img-fluid mx-auto d-block' width='500'>" : "<img src='../ComprovantesPago/Rechazados/" . $row['comprovante_pago'] . ".png' alt='Comprovante3' class='img-fluid mx-auto d-block' width='500'>" )) : "<img src='../imagenes/No_Existente/Comprovante_no_Existente.png' alt='Comprovant4e' class='img-fluid mx-auto d-block' width='500'>";
                        }
                    }
                    ?>
                </div>
                <br>
                <form method="post" action="<?php echo $_SESSION['PaginaAnteriorAuxiliar2'] ?>">
                    <div class="d-flex justify-content-center">
                        <input type="hidden" name="idDeuda" id="idDeuda" value="<?php echo (isset($_POST['idDeuda'])) ? $_POST['idDeuda'] : "" ?>">
                        <button type="submit" class="btn btn2" name="Volver" value="Volver">Volver</button>
                    </div>
                </form>  
            </div>
        </div>

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
