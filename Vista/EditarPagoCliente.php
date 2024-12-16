<?php
//require '../ConexionBD/conexion.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/EditarPagoCliente.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarEditarPagoCliente.php")) {
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/EditarPagoCliente.php";
}

require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
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
        <link rel="stylesheet" href="../Estilos/EstilosEditarPagoCliente.css">
    </head>
    <body>
        <?php
        $conceptos = ["Valor Pago", "Id Deuda"];
        $id_pago = (isset($_POST['idPago'])) ? $_POST['idPago'] : "null";

        $result0 = $consulta->ObtenerValorPago_IdDeuda_PorIdPago($id_pago);

        if (($result0->num_rows) > 0) {
            $row = $consulta->obtenerDatosDeLasConsultas($result0);
            $row0 = array_values($row);

            $result1 = $consulta->ObtenerIdDeudasActivas_y_Totalpagar_PorIdUsuario($_SESSION['idUsuario']);
            ?>
            <div class="container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-6">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                            <div class="ml-auto slogan">
                                <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Registro Pago.</p>
                            </div>
                        </nav>

                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title text-center"><?php echo $_SESSION['nombreUsuario'] ?> inserta los nuevos datos</h5>
                                <div class="row-md-8 slogan">
                                    <p style="text-align: center;"> <i> solo es nesesario ingresar los datos que copten tu interes </i></p>
                                </div>
                                <form action="../Controlador/ProcesarEditarPagoCliente.php" method="post" id="formulario1" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="usuario" class="text-center d-block"><b>id Pago</b></label>
                                        <input type="text" class="form-control text-center" id="correo" name="idPago" value="<?php echo $id_pago ?>" readonly>
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-borderless">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Concepto</th>
                                                        <th class="text-center">Actual</th>
                                                        <th class="text-center">Nuevo</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    for ($i = 0; $i < count($conceptos); $i++) {
                                                        ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $conceptos[$i] ?></td>
                                                            <td><input class="form-control text-center" type="text" name="<?php echo str_replace(" ", "", $conceptos[$i]) ?>Actual" value="<?php echo $row0[$i] ?>" readonly></td>
                                                            <?php if ($i == 0) { ?>
                                                                <td><input class="columa2 form-control text-center" type="number" name="<?php echo str_replace(" ", "", $conceptos[$i]) ?>Nuevo" value="0"></td>
                                                            <?php } else { ?>
                                                                <td>
                                                                    <select class="columa2 form-select form-control" name="select1">
                                                                        <option value="<?php echo ($row0[1] . "-" . $row0[2] . "-" . $id_pago) ?>"></option>
                                                                        <?php
                                                                        if (($result1->num_rows) > 0) {
                                                                            while ($row2 = $consulta->obtenerDatosDeLasConsultas($result1)) {
                                                                                ?>
                                                                                <option value="<?php echo ($row2['id_deuda'] . "-" . $row2['total_pagar'] . "-" . $_POST['idPago']) ?>"><?php echo "Id: " . $row2['id_deuda'] . " - Total: " . $row2['total_pagar'] ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </td>
                                                            <?php } ?>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imagen" class="form-label text-center d-block">Subir Comprobante (Para pagos virtuales)</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="imagen" name="imagen">
                                            <label class="custom-file-label" for="imagen">Selecciona un archivo...</label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary" name="continuar" value="continuar">Continuar</button>
                                        <button type="submit" class="btn btn-secondary" name="volver" value="volver">Volver</button>
                                    </div>
                                </form>
                            <?php } else { ?>
                                <form action="../Controlador/ProcesarEditarPagoCliente.php" method="post" id="formulario1">
                                    <input type="submit" class="btn btn-secondary btn-lg btn-block" value="volver" name="volver">
                                </form>
                            <?php } ?>
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
