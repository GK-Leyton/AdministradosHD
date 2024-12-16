<?php
require '../Modelo/ConsultasUsuarios.php';
if (!isset($_SESSION)) {
    session_start();
}
//echo "<h1>".$_SESSION['PaginaAnteriorAuxiliar']."</h1>";
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if ((isset($_SESSION['PaginaAnterior'])) && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/MasInformacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php")) {
//    echo "<h1>Redirigido a ".$_SESSION['PaginaAnterior']."</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/MasInformacion.php";
    $_SESSION['PaginaAnteriorAuxiliar2'] = "../Vista/MasInformacion.php";
}


$consulta = new consultasUsuario();
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";
/* $stmt = $conn->prepare("select * from pagos where id_deuda = ?;");
  $stmt->bind_param("s", $_POST['idDeuda']);
  $stmt->execute();
  $result = $stmt->get_result(); */
$result = $consulta->ObtenerPagosPorIdDeuda($_POST['idDeuda']);
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
        <link rel="stylesheet" href="../Estilos/EstilosMasInformacion.css" >

        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container">
            <!-- Logo y Slogan -->
            <div class="row justify-content-center row-mt-2">
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
                                <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Pagos Realizados</p>
                            </div>
                            </div>

                            </div>

                            <!-- Encabezado con título -->


                            <!-- Tabla de deudas activas -->
                            <div class="justify-content-center">
                                <div class="md-10">
                                    <div class="table-responsive">

                                        <!-- Ejemplo de fila de deuda activa -->

                                        <?php
                                        if (($result->num_rows) > 0) {
                                            ?>
                                            <div class="row justify-content-center">
                                                <div style="padding-bottom: 2em; padding-top: 3em;">
                                                    <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Avanzes realizados en esta deuda</p>
                                                </div>
                                            </div>
                                            <table class="table table-borderless">
                                                <thead>

                                                    <tr>
                                                        <th>ID Pago</th>
                                                        <th>Valor Pago</th>
                                                        <th>ID Deuda</th>
                                                        <th>Fecha pago</th>                                
                                                        <th>Estado</th> 
                                                        <th>Comprovante</th> 
                                                    </tr>

                                                </thead>
                                                <tbody>                            
                                                    <?php
                                                    //while($row = $result->fetch_assoc()) {                                                                                                                               
                                                    while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo($row['id_pago']) ?></td>
                                                            <td><?php echo($row['valor_pago']) ?></td>
                                                            <td><?php echo($row['id_deuda']) ?></td>
                                                            <td><?php
                                                                if ($row['fecha_pago'] == null) {
                                                                    echo"Dato Antiguo";
                                                                } else {
                                                                    echo($row['fecha_pago']);
                                                                }
                                                                ?></td>
                                                            <td><?php echo ($row['estado'] == 0 ) ? "Aceptado" : (($row['estado'] == 1 ) ? "pendiente" : "Rechazado"); ?></td>
                                                            <td><form method="post"action="../Vista/VerComprovantePago.php">
                                                                    <input type="hidden" name="idPago" value="<?php echo($row['id_pago']) ?>">                                                                                                
                                                                    <input type="hidden" name="idDeuda" value="<?php echo ($row['id_deuda']) ?>">
                                                                    <input type="hidden" name="paraPagos" value="<?php echo "true" ?>">
                                                                    <button type="submit" class="btn btn-success btn-block" name="Ver_Comprovante">Comprovante</button>                                                                                                
                                                                </form></td>

                                                        </tr>
                                                        <?php
                                                    }
                                                } else {
                                                    echo"<h3 style='text-align: center;'>No hay pagos registrados para esta deuda</h3>";
                                                    echo"<div class='col justify-content-center'>
                                    <div class='row-md-8 logo'>";
                                                    echo"<img src='../imagenes/No_Existente/No_Pagos_En_Deuda.png' alt='sin pagos' class='img-fluid' width='450'>";
                                                    echo "</div> </div>";
                                                }
                                                ?>                            
                                                <!-- Ejemplo de otra fila -->

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

                            <?php
                            /* /
                              if((isset($_SESSION['PaginaAnteriorAuxiliar']))&&  $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/DeudasFinalizadasCliente.php"){

                              ?>
                              <form action="../Vista/DeudasFinalizadasCliente.php" method="post">
                              <?php
                              }else if((isset($_SESSION['PaginaAnteriorAuxiliar']))&&  $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/DeudasActivasCliente.php"){

                              ?>
                              <form action="../Vista/DeudasActivasCliente.php" method="post">
                              <?php
                              }else if((isset($_SESSION['PaginaAnteriorAuxiliar']))&&  $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/DeudasActivasAdmin.php"){

                              ?>
                              <form action="../Vista/DeudasActivasAdmin.php" method="post">
                              <?php
                              }else if((isset($_SESSION['PaginaAnteriorAuxiliar']))&&  $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/DeudasFinalizadasAdmin.php"){

                              ?>
                              <form action="../Vista/DeudasFinalizadasAdmin.php" method="post">
                              <?php
                              } */
                            ?>
                            <br>

                            <form action="<?php echo $_SESSION['PaginaAnteriorAuxiliar'] ?>" method="post">    
                                <div class="d-flex justify-content-center">               
                                    <button type="submit" class="btn btn2" name="Ingresar" value="Ingresar">Volver</button><!-- comment -->
                                </div>
                            </form>   


                            <script>
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