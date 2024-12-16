<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazAdministrador.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarEstadoPagos.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php")) {
    //echo "<h1>LLendo a  " . $_SESSION['PaginaAnterior'] . "</h1>";
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/VerPagosAdmin.php";
    $_SESSION['PaginaAnteriorAuxiliar2'] = "../Vista/VerPagosAdmin.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>"; 
//require '../ConexionBD/conexion.php';
require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
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
        <link rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosVerPagosAdmin.css">

        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container">
            <div class="row justify-content-center mt-3">       
                <div class="col-md-6" >

                    <nav style="margin-top: 2em;" class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/InterfazAdministrador.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Pagos.</p>
                        </div>

                </div>            
            </div>            


            <!-- Logo y Slogan -->
            <div style="padding-top: 1em;" class="row justify-content-center">            
                <div class="col-md-8 slogan">
                    <p>Es bueno recordar nuestra historia.</p>
                </div>
            </div>

            <!-- Encabezado con título -->



            <div class="row justify-content-center mt-4">
                <form method="post" action="../Vista/VerPagosAdmin.php" id="formulario1">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="options" id="option5" value="<?php echo (isset($_POST['options'])) ? $_POST['options'] : "todos"; ?>" onchange="enviarRadio()" checked >

                        <input class="form-check-input" type="radio" name="options" id="option4" value="3" onchange="enviarRadio()" >                    
                        <label class="form-check-label" for="option0">Todos</label>
                        <br>
                        <input class="form-check-input" type="radio" name="options" id="option0" value="0" onchange="enviarRadio()"  >                    
                        <label class="form-check-label" for="option0">Aceptados</label>
                        <br>
                        <input class="form-check-input" type="radio" name="options" id="option1" value="1" onchange="enviarRadio()">
                        <label class="form-check-label" for="option1">Pendientes</label>
                        <br>
                        <input class="form-check-input" type="radio" name="options" id="option2" value="2" onchange="enviarRadio()">
                        <label class="form-check-label" for="option2">Rechazados</label>                                            
                    </div>


                    <script>
                        function enviarRadio() {
                            document.getElementById("formulario1").submit();
                        }
                    </script>                                    
                </form>
            </div>     

            <?php
            if (isset($_POST['options'])) {
                $estado = (isset($_POST['options'])) ? $_POST['options'] : "0";
                $auxiliarSimbolo = (isset($_POST['options']) && $_POST['options'] == 3) ? ">=" : "=";
                $auxiliar_consulta = " ;";

                if ($estado < 3) {
                    /* $stmt0 = $conn->prepare("select DISTINCT nombre_usuario , usuario.id_usuario from pagos INNER JOIN deudas
                      on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
                      on deudas.id_usuario = usuario.id_usuario
                      where pagos.estado = ".$estado."
                      GROUP BY nombre_usuario;");
                      $stmt0->execute();
                      $result0 = $stmt0->get_result(); */
                    $result0 = $consulta->ObtenerXIntormacionClientePorEstado($estado);
                    ?>
                    <br>
                    <div class="row-md-8 text-center">
                        <form method="post" action="../Vista/VerPagosAdmin.php" id="formulario2">
                            <label for="selectCliente">Selecciona una opción</label>

                            <!-- Encabezado con título -->
                            <input class="form-check-input" type="radio" name="options" id="option6" value=" <?php echo ($_POST['options']); ?>"  checked  style="visibility: hidden">                    
                            <select class="form-select" id="selectCliente" name="selectCliente" onchange="enviarSelect()">                                    
                                <option value="0"></option>
                                <?php
                                if (($result0->num_rows) > 0) {
                                    while ($row0 = $result0->fetch_assoc()) {
                                        echo"<option value='" . $row0['id_usuario'] . "'>" . $row0['nombre_usuario'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <input class="form-check-input" type="radio" name="options" id="option0" value="<?php echo($_POST['options']) ?>" onchange="enviarRadio()" style="display: none;"  selected>                    

                            <script>
                                function enviarSelect() {
                                    document.getElementById("formulario2").submit();
                                }
                            </script>                                    

                    </div>
                </form>
            </div>




            <?php
            if (isset($_POST['selectCliente'])) {
                $id_usuario = $_POST['selectCliente'];
                $auxiliar_consulta = "and usuario.id_usuario " . $auxiliarSimbolo . " " . $id_usuario . ";";
            }
        }
        if ($estado == 3) {
            $id_usuario = 0;
            $estado = 0;
        }

        /*            $stmt = $conn->prepare("select pagos.* , usuario.nombre_usuario , usuario.id_usuario from pagos INNER JOIN deudas
          on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
          on deudas.id_usuario = usuario.id_usuario
          where pagos.estado ".$auxiliarSimbolo." ?  ".$auxiliar_consulta." ");
          $stmt->bind_param("s",$estado );
          $stmt->execute();
          $result = $stmt->get_result(); */
        $result = $consulta->ObtenerXIntormacionClientePorEstado_Complemento($estado, $auxiliarSimbolo, $auxiliar_consulta);
        ?>
        <!-- Tabla de deudas activas -->
        <div class="col justify-content-center col-md">

            <div class="table-responsive">

                <!-- Ejemplo de fila de deuda activa -->

                <?php
                if (($result->num_rows) > 0) {
                    ?>
                    <table class="table table-borderless">
                        <thead>

                            <tr>
                                <th>ID Cliente</th>
                                <th>Nombre Cliente</th>
                                <th>ID Pago</th>
                                <th>Valor Pago</th>
                                <th>Estado Pago</th>
                                <th>ID Deuda</th>
                                <th>Fecha pago</th>  
                                <th>Comprovante <br> Pago</th>
                                <?php
                                if ($_POST['options'] == "1") {
                                    ?>
                                    <th>Acción</th>   
                                <?php } ?>
                            </tr>

                        </thead>
                        <tbody>                            
                            <?php
                            //while ($row = $result->fetch_assoc()) {
                            $contador = 0;
                            while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {
                                ?>
                                <tr>
                                    <td><?php echo($row['id_usuario']) ?></td>
                                    <td><?php echo($row['nombre_usuario']) ?></td>
                                    <td><?php echo($row['id_pago']) ?></td>
                                    <td><?php echo($row['valor_pago']) ?></td>
                                    <td><?php echo($row['estado']) ?></td>
                                    <td><?php echo($row['id_deuda']) ?></td>                                            
                                    <td><?php
                                        if ($row['fecha_pago'] == null) {
                                            echo"Dato Antiguo";
                                        } else {
                                            echo($row['fecha_pago']);
                                        }
                                        ?></td>

                                    <td>
                                        <div class="logo text-center">
                                            <form method="post"action="../Vista/VerComprovantePago.php">
                                                <input type="hidden" style="display: none" name="idPago" value="<?php echo($row['id_pago']) ?>">                                                                                                
                                                <button type="submit" class="btn btn1 btn-block" name="Ver_Comprovante">Ver Comprovante</button>
                                            </form>
                                            <button class="mostrarImagenBtn btn btn0 btn-block" style="margin-top: 5px;">Desplegar Comprovante Pago</button>
                                            <div class="imagen-container">

                                                <?php
                                                $rutaComprovante = "../imagenes/No_Existente/";

                                                if (isset($row['comprovante_pago']) && $row['comprovante_pago'] != null) {

                                                    if (isset($row['estado']) && $row['estado'] == 0) {
                                                        $rutaComprovante = "../ComprovantesPago/Confirmados/";
                                                    } else if (isset($row['estado']) && $row['estado'] == 1) {
                                                        $rutaComprovante = "../ComprovantesPago/PorConfirmar/";
                                                    } else if (isset($row['estado']) && $row['estado'] == 2) {
                                                        $rutaComprovante = "../ComprovantesPago/Rechazados/";
                                                    }
                                                }
                                                $nombreComprovante = (isset($row['comprovante_pago']) && $row['comprovante_pago'] != null) ? $row['comprovante_pago'] . ".png" : 'Comprovante_No_Existente.png';
                                                //echo "<h1>".$rutaComprovante.$nombreComprovante."</h1>"; 
                                                ?>
                                                <img class="imagen" src="<?php echo $rutaComprovante . $nombreComprovante; ?>" alt="Imagen">

                                            </div>

                                        </div>

                                    </td>
                                    <?php
                                    if ($_POST['options'] == "1") {
                                        ?>
                                        <td>
                                            <div class="logo text-center">
                                                <form method="post"action="../Controlador/ProcesarEstadoPagos.php">
                                                    <input type="hidden" name="idPago" value="<?php echo($row['id_pago']) ?>">
                                                    <input type="hidden" name="montoPago" value="<?php echo($row['valor_pago']) ?>">
                                                    <input type="hidden" name="idDeuda" value="<?php echo($row['id_deuda']) ?>">                                                    

                                                    <button type="submit" class="btn btn2 btn-block" name="aceptar">Aceptar</button>
                                                    <button type="submit" class="btn btn0 btn-block" name="declinar">Declinar</button>

                                                </form>
                                            </div>
                                        </td>
                                    <?php } ?>

                                </tr>
                                <?php
                            }
                        } else {
                            echo"<h3 style='text-align: center;'>Seleccione un cliente</h3>";
                            ?> 
                        <div class = "col justify-content-center">
                            <div class = "row-md-8 logo">
                                <img src = "../imagenes/No_Existente/No_Pagos_Por_Por_Parte_Clientes.png" alt = "Logo" class = "img-fluid" width = "200">
                            </div>
                        </div>
                        <?php
                    }
                    ?>                            
                    <!-- Ejemplo de otra fila -->

                    </tbody>
                </table>
            </div>

        </div>


        <!-- Bootstrap JS y dependencias -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <br><br>    



        <?php
    }
    ?>


    <form method="post" action="../Vista/InterfazAdministrador.php">

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn2" name="Ingresar" value="Ingresar">Volver</button><!-- comment -->
        </div>
    </form>    
    <br>
</div>
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