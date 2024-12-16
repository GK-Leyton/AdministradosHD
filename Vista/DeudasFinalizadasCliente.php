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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/MasInformacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php")) {
    //   echo "<h1>Redirigido a " . $_SESSION['PaginaAnterior'] . "</h1>";
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/DeudasFinalizadasCliente.php";
    $_SESSION['PaginaAnteriorAuxiliar'] = "../Vista/DeudasFinalizadasCliente.php";
    $_SESSION['PaginaAnteriorAuxiliar2'] = "../Vista/DeudasFinalizadasCliente.php";
}



//require '../ConexionBD/conexion.php';
require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();

/* $stmt = $conn->prepare("select * from deudas where id_usuario = ? AND estado = 0;");
  $stmt->bind_param("s", $_SESSION['idUsuario']);
  $stmt->execute();
  $result = $stmt->get_result(); */
$result = $consulta->ObtenerDeudasPorIdUario_y_Estado($_SESSION['idUsuario'], 0)
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
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/EstilosDeudasFinalizadasCliente.css">

        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">        
    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container">
            <!-- Logo y Slogan -->
            <div class="row justify-content-center mt-3">
                <div class="col-md-6" >

                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/Interfazcliente.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">deudas finalizadas.</p>
                        </div>

                </div>

            </div>
            <?php if (($result->num_rows) > 0) { ?>
                <!-- Encabezado con título -->
                <div class="row justify-content-center mt">
                    <div class="col-md-8 text-center">
                        <h5 style="margin-top: 1em; margin-bottom: 2em;" class="slogan" > En la era digitall la informacion está en tus manos <?php echo($_SESSION['nombreUsuario']) ?> </h5>
                    </div>
                </div>

                <!-- Tabla de deudas activas -->
                <div class="row justify-content-center m">
                    <div class="col-md">
                        <div class="table-responsive">
                            <table class="table table-borderless">
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
                                        <th>Ver Acciones</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <!-- Ejemplo de fila de deuda activa -->

                                    <?php
                                    //while($row = $result->fetch_assoc()) {
                                    while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {

                                        /* $stmt2 = $conn->prepare("select  SUM(valor_pago) total_pagado from pagos
                                          WHERE id_deuda = ? and estado = 1
                                          GROUP BY id_deuda;
                                          ");
                                          $stmt2->bind_param("s", $row['id_deuda']);
                                          $stmt2->execute();
                                          $result2 = $stmt2->get_result();
                                          $row2 = $result2->fetch_assoc(); */
                                        $result2 = $consulta->ObtenerTotalPagadoPorIdDeuda_y_estado($row['id_deuda'], 0);
                                        $row2 = $consulta->obtenerDatosDeLasConsultas($result2);
                                        /* $stmt3 = $conn->prepare("select (valor_actual + interes) as TOTAL from deudas
                                          WHERE id_deuda = ? ; ");
                                          $stmt3->bind_param("s", $row['id_deuda']);
                                          $stmt3->execute();
                                          $result3 = $stmt3->get_result();
                                          $row3 = $result3->fetch_assoc(); */
                                        $result3 = $consulta->obtenerTotalDeudaPorIdDeuda($row['id_deuda']);
                                        $row3 = $consulta->obtenerDatosDeLasConsultas($result3);
                                        ?>
                                        <tr>
                                            <?php
                                            if ($row['estado'] != 1) {

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
                                                ?></td>
                                                <td><?php echo($row['interes']) ?></td>
                                                <td><?php echo($row['id_usuario']) ?></td>
                                                <td><?php echo($row['credencial_usuario']) ?></td>
                                                <td><form method="post"action="../Vista/VerComprovantePago.php">
                                                        <input type="hidden" name="idDeuda" value="<?php echo($row['id_deuda']) ?>">                                                                                                
                                                        <button type="submit" class="btn0 btn-primary btn-block btn-block" name="Ver_Comprovante">Comprovante</button>                                                                                                
                                                    </form>
                                                    <button class="btn1 mostrarImagenBtn btn btn-block" style="margin-top: 5px;">Desplegar Comprovante Pago</button>
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
                                                        <button class="btn btn0 btn-sm btn-block mt-1">Mas Info</button>
                                                    </form>

                                                </td>
                                            </tr>
                                        <?php
                                        }
                                    }
                                } else {

                                    echo "<div class='row justify-content-center'>
                    <div class='col-md-8 logo'>
                        <img src='../imagenes/No_Existente/No__Deudas_Activas.png' alt='Logo' class='img-fluid' width='300'>
                    </div>
                    </div>";
                                }
                                ?>                            
                                <!-- Ejemplo de otra fila -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Bootstrap JS y dependencias -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

            <form action="interfazCliente.php" method="post">
                <?php
                /* $stmt2 = $conn->prepare("SELECT SUM(TOTAL) AS total_sumado
                  FROM (
                  SELECT SUM(valor_pago) AS TOTAL
                  FROM pagos inner join deudas
                  on pagos.id_deuda = deudas.id_deuda inner join usuario
                  on deudas.id_usuario = usuario.id_usuario
                  WHERE usuario.id_usuario = ? AND deudas.estado = 0 AND pagos.estado = 0
                  ) AS subconsulta;
                  ");
                  $stmt2->bind_param("s", $_SESSION['idUsuario']);
                  $stmt2->execute();
                  $result2 = $stmt2->get_result(); */
                $result2 = $consulta->ObtenerValorSumadoDeudasPorIdUsuario_y_EstadoInactivo($_SESSION['idUsuario']);
                $row2 = $consulta->obtenerDatosDeLasConsultas($result2);
                ?>



                <h3 style="text-align: center;"> En el pasado nos han unido  <b><?php echo (isset($row2['total_sumado'])) ? $row2['total_sumado'] : "0" ?></b> deseos Colombianos</h3>        
                <div class="d-flex justify-content-center">                
                    <button type="submit" class="btn btn2" name="Ingresar" value="Ingresar">Volver</button><!-- comment -->
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
        </div>
        <button id="scrollToBotBtn" title="Volver abajo">
            <i class="fa fa-arrow-down"></i>
        </button>


        <button id="scrollToTopBtn" title="Volver arriba">
            <i class="fa fa-arrow-up"></i>
        </button>           
    </body>
</html>
