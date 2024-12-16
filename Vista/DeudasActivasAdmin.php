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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazAdministrador.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/MasInformacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerNotificacion.php")) {
    // echo "<h1>LLendo a  " . $_SESSION['PaginaAnterior'] . "</h1>";
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/DeudasActivasAdmin.php";
    $_SESSION['PaginaAnteriorAuxiliar'] = "../Vista/DeudasActivasAdmin.php";
    $_SESSION['PaginaAnteriorAuxiliar2'] = "../Vista/DeudasActivasAdmin.php";
}

//echo "<h1>" . $_SESSION['PaginaAnterior'] . "</h1>";
//require '../ConexionBD/conexion.php';
require '../Modelo/ConsultasUsuarios.php';
$Consulta = new consultasUsuario();
$_SESSION['pagAnterior'] = "Deudas_activas_admin";

/* $stmt0 = $conn->prepare("select DISTINCT  credencial_usuario from deudas where estado = 1 GROUP BY credencial_usuario;");
  $stmt0->execute();
  $result0 = $stmt0->get_result(); */
$result0 = $Consulta->ObtenerCredencialUsuarioPorEstadoDeudaActiva();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deudas Activas</title>
        <!-- Bootstrap CSS -->
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosDeudasActivasAdmin.css">

        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container">
            <!-- Logo y Slogan -->
            <div class="row justify-content-center mt-3">           
                <div class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/InterfazAdministrador.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Conexiones Activas.</p>
                        </div>

                </div>              
            </div>              

            <div style="padding-top: 3em;" class="row justify-content-center">

                <div class="col-md-8 text-center slogan">
                    <p>Cuidamos tus cuentas, por ello te facilitamos <b>ADMIN</b>istrarlas.</p>
                </div>
            </div>

            <!-- Encabezado con título -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-8 text-center">
                    <!-- Combobox de Bootstrap -->
                    <div class="form-group">
                        <form method="post" action="../Vista/DeudasActivasAdmin.php" id="formulario1">
                            <label for="selectDeudas">Selecciona una opción</label>
                            <select class="form-select" id="selectDeudas" name="selectDeudas" onchange="enviarSelect()">                                    
                                <option value="-1"></option>
                                <option value="0">Todos</option>
                                <?php
                                if (($result0->num_rows) > 0) {
                                    while ($row0 = $Consulta->obtenerDatosDeLasConsultas($result0)) {
                                        echo "<option value='" . $row0['credencial_usuario'] . "'>" . $row0['credencial_usuario'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <script>
                                function enviarSelect() {
                                    document.getElementById("formulario1").submit();
                                }
                            </script>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['selectDeudas'])) {
                        ?>

                    </div>


                    <!-- Tabla de deudas activas -->

                    <div class="col-md-10">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID Deuda</th>
                                        <th>Valor Inicial</th>
                                        <th>Valor Actual</th>
                                        <th>Total</th>
                                        <th>Porcentaje de Interés</th>
                                        <th>Total Pagado</th>
                                        <th>Interés Total</th>
                                        <th>ID Usuario</th>
                                        <th>Credencial Usuario</th>
                                        <th>Comprovante Deuda</th>
                                        <th>Informacion y pago</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $auxiliarSimbolo = "=";
                                    if (isset($_POST['selectDeudas'])) {
                                        if ($_POST['selectDeudas'] == 0) {
                                            $auxiliarSimbolo = ">=";
                                        }
                                    }
                                    $result = $Consulta->ObtenerDeudasActivasPorCredencialUsuario($auxiliarSimbolo, $_POST['selectDeudas']);
                                    if (($result->num_rows) > 0) {
                                        while ($row = $Consulta->obtenerDatosDeLasConsultas($result)) {
                                            $result2 = $Consulta->ObtenerTotalPagadoPorIdDeuda_y_estado($row['id_deuda'], 0);
                                            if (($result2->num_rows) > 0) {
                                                $row2 = $Consulta->obtenerDatosDeLasConsultas($result2);
                                            }
                                            $result3 = $Consulta->obtenerTotalDeudaPorIdDeuda($row['id_deuda']);
                                            if (($result3->num_rows) > 0) {
                                                $row3 = $Consulta->obtenerDatosDeLasConsultas($result3);
                                            }
                                            ?>
                                            <tr>
                                                <?php
                                                if ($row['estado'] == 1) {
                                                    $_SESSION['idDeuda'] = $row['id_deuda'];
                                                    ?>
                                                    <td><?php echo($row['id_deuda']) ?></td>
                                                    <td><?php echo($row['valor_inicial']) ?></td>
                                                    <td><?php echo($row['valor_actual']) ?></td>
                                                    <td><?php echo($row3['TOTAL']) ?></td>
                                                    <td><?php echo($row['porcentaje_interes']) ?></td>
                                                    <td><?php
                                                        if (isset($row2['total_pagado'])) {
                                                            echo($row2['total_pagado']);
                                                        } else {
                                                            echo("Sin pagos");
                                                        }
                                                        if (isset($row2['total_pagado'])) {
                                                            unset($row2['total_pagado']);
                                                        }
                                                        ?></td>
                                                    <td><?php echo($row['interes']) ?></td>
                                                    <td><?php echo($row['id_usuario']) ?></td>
                                                    <td><?php echo($row['credencial_usuario']) ?></td>
                                                    <td>
                                                        <form method="post" action="../Vista/VerComprovantePago.php">
                                                            <input type="hidden" name="idDeuda" value="<?php echo($row['id_deuda']) ?>">                                                                                                
                                                            <button type="submit" class="btn btn0 btn-block" name="Ver_Comprovante">Comprovante</button>                                                                                                
                                                        </form>

                                                        <button class="mostrarImagenBtn btn btn2 btn-block" style="margin-top: 5px;">Desplegar Comprovante Pago</button>
                                                        <div class="imagen-container">

                                                            <?php
                                                            $rutaComprovante = "../imagenes/No_Existente/";

                                                            if (isset($row['comprovante_deuda']) && $row['comprovante_deuda'] != null) {

                                                                if (isset($row['estado'])) {
                                                                    $rutaComprovante = "../ComprovantesDeuda/Aprovados/";
                                                                }
                                                            }
                                                            $nombreComprovante = (isset($row['comprovante_deuda']) && $row['comprovante_deuda'] != null) ? $row['comprovante_deuda'] . ".png" : 'Comprovante_No_Existente.png';
                                                            //echo "<h1>".$rutaComprovante.$nombreComprovante."</h1>"; 
                                                            ?>
                                                            <img class="imagen" src="<?php echo $rutaComprovante . $nombreComprovante; ?>" alt="Imagen">

                                                        </div>                                                        
                                                    </td>
                                                    <td>
                                                        <form method="post" action="MasInformacion.php">
                                                            <input type="hidden" value="<?php echo $row['id_deuda'] ?>" name="idDeuda">
                                                            <button class="btn btn-primary btn0 btn-block mt-1">Info</button>
                                                        </form>
                                                        <form method="post" action="RealizarPagoAdmin.php">
                                                            <input type="hidden" value="<?php echo ($row['id_deuda']); ?>" name="idDeuda">
                                                            <input type="hidden" value="<?php echo ($row3['TOTAL']); ?>" name="totalPagar">
                                                            <input type="hidden" value="<?php echo ($row['interes']); ?>" name="totalIntereses">
                                                            <?php
                                                            $resultAuxiliar = $Consulta->ConocerCantidadDeudasSinInteres($row['id_usuario']);
                                                            if ($resultAuxiliar->num_rows > 0) {
                                                                $rowAuxiliar = $Consulta->obtenerDatosDeLasConsultas($resultAuxiliar);
                                                            }
                                                            $diabled = (($rowAuxiliar['cantidad'] > 0) && ($row['porcentaje_interes'] > 0)) ? 'disabled="true"' : '';
                                                            ?>

                                                            <button class="btn btn1 btn-sm btn-block" <?php echo $diabled ?>  >Pago</button>
                                                        </form>    
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap JS y dependencias -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <br><br>

            <?php
            $result2 = $Consulta->ObtenerValorSumadoDeudasPorCredencialUsuario_y_EstadoActivo($auxiliarSimbolo, $_POST['selectDeudas']);
            if (($result2->num_rows) > 0) {
                $row2 = $Consulta->obtenerDatosDeLasConsultas($result2);
                ?>
                <h3 style="text-align: center;"> Hoy nos unen <b><?php echo($row2['total_sumado']) ?></b> deseos Colombianos</h3>        
                <?php
            }
        }
        ?>
        <br><br>
        <form action="InterfazAdministrador.php" method="post">
            <div class="d-flex justify-content-center">                
                <button type="submit" class="btn btn2" name="Ingresar" value="Ingresar">Volver</button>
            </div>
        </form>   
        <br>
        <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    document.querySelectorAll('.mostrarImagenBtn').forEach(button => {
                                        button.addEventListener('click', function () {
                                            const imagenContainer = this.nextElementSibling;
                                            if (imagenContainer.classList.contains('visible')) {
                                                imagenContainer.classList.remove('visible');
                                            } else {
                                                imagenContainer.classList.add('visible');
                                            }
                                        });
                                    });
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
