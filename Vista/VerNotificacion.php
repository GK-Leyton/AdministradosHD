<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerNotificacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazAdministrador.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/VerNotificacion.php";
}


//echo "<h1>".$_SESSION['PaginaAnterior']." </h1>";
require '../Modelo/ConsultasUsuarios.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$consulta = new consultasUsuario();
$result = "";
$result0 = "";
if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "0" )) {
    $result = $consulta->ObtenerInformacionDeuda_Por_Notificaciones($_POST['idNotificacion']);
    $result0 = $consulta->ObtenerFotoPerfil_ComprovanteDeuda_PorNotificacion($_POST['idNotificacion']);
} else if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "1" )) {
    $result = $consulta->ObtenerInformacionPago_Por_Notificaciones($_POST['idNotificacion']);
    $result0 = $consulta->ObtenerFotoPerfil_ComprovantePago_PorNotificacion($_POST['idNotificacion']);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Perfil de Usuario</title>
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>
        <link rel="stylesheet" href="../Estilos/EstilosVerNotificacion.css">
        <style>
            .logo {
                width: 100px;
                height: auto;
                margin: 0 auto;
            }
            .profile-pic-circle {
                width: 150px;
                height: 150px;
                border-radius: 50%;
                border: 4px solid #007bff; /* Borde azul */
                object-fit: cover;
            }



            .imagen-container {
                max-height: 0;
                opacity: 0;
                overflow: hidden;
                transition: max-height 0.5s ease, opacity 0.5s ease;
            }
            .imagen-container.visible {
                max-height: 1000px; /* Un valor suficientemente grande para desplegar la imagen completa */
                opacity: 1;
            }
            .imagen {
                width: 20em; /* Ajusta el tamaño según tus necesidades */
                height: auto;
            }
        </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row justify-content-center row-mt-2">
                <div class="col-md-12">
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
                                <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Notificación</p>                        
                            </div>

                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center">
                                    <?php
                                    if ($result->num_rows > 0) {



                                        $row = $consulta->obtenerDatosDeLasConsultas($result);

                                        if ($result0->num_rows > 0) {
                                            $row0 = $consulta->obtenerDatosDeLasConsultas($result0);
                                            $modificador = new insertsUpdates();
                                            if (isset($_SESSION['PaginaAnteriorAuxiliar']) && ($_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/InterfazCliente.php" )) {
                                                $stmt = $modificador->ActualizarEstadoNotificaciones($_POST['idNotificacion'], 0, "estado");
                                            } else if (isset($_SESSION['PaginaAnteriorAuxiliar']) && ($_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/InterfazAdministrador.php" )) {
                                                $stmt = $modificador->ActualizarEstadoNotificaciones($_POST['idNotificacion'], 0, "estado2");
                                            }
                                        }
                                        ?>
                                        <img src="../FotosPerfil/Confirmadas/<?php echo (isset($row0['foto_perfil'])) ? $row0['foto_perfil'] : "Predeterminada" ?>.png" class="col profile-pic-circle" alt="Foto de perfil">

                                        <div class="col card-body text-center">


                                            <!-- para mostar Comprovantes de deudas -->
                                            <button class="mostrarComprovante btn btn1 btn-block" style="margin-top: 5px;">Desplegar Comprovante</button>
                                            <?php if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "0" )) { ?>
                                                <div class="imagen-container">
                                                    <?php echo "<h1> coco " . $row0['comprovante_deuda'] . "</h1>" ?>
                                                    <img class="imagen" src="<?php echo (isset($row0['comprovante_deuda']) && ($row0['comprovante_deuda'] != null)) ? "../ComprovantesDeuda/Aprovados/" . $row0['comprovante_deuda'] : "../imagenes/No_Existente/Comprovante_no_Existente"; ?>.png" alt="Imagen">
                                                </div>
                                            <?php } ?>


                                            <!-- para mostar Comprovantes de pagos -->  

                                            <?php
                                            if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "1" )) {
                                                $ruta = "";
                                                if (isset($row['estado']) && $row['estado'] == 0) {
                                                    $ruta = "../ComprovantesPago/Confirmados/" . $row0['comprovante_pago'];
                                                } else if (isset($row['estado']) && $row['estado'] == 1) {
                                                    $ruta = "../ComprovantesPago/PorConfirmar/" . $row0['comprovante_pago'];
                                                } else if (isset($row['estado']) && $row['estado'] == 2) {
                                                    $ruta = "../ComprovantesPago/Rechazados/" . $row0['comprovante_pago'];
                                                }
                                                ?>

                                                <div class="imagen-container">

                                                    <img class="imagen" src="<?php echo $ruta ?>.png" alt="Imagen">
                                                </div>
                                            <?php } ?>

                                        </div>

                                    </div>
                                    <div class="col-md-8">
                                        <div class="card">
                                            <div class="card-body">
                                                <?php if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "0" )) { ?>



                                                    <h5 style="text-align: center;" class="card-title">Informacion actualizada  a fecha de <?php echo date('Y-m-d') ?> </h5>
                                                    <p class="card-text"><strong>ID Deuda:</strong><?php echo $row['id_deuda'] ?> </p>
                                                    <p class="card-text"><strong>Valor Inicial Deuda:</strong><?php echo $row['valor_inicial'] ?> </p>
                                                    <p class="card-text"><strong>Valor Actual Deuda:</strong><?php echo $row['valor_actual'] ?></p>
                                                    <p class="card-text"><strong>Total Deuda:</strong><?php echo $row['total'] ?></p>
                                                    <p class="card-text"><strong>Total Intereses:</strong><?php echo $row['interes'] ?></p>
                                                    <p class="card-text"><strong>Interes Sumado (proximo):</strong><?php echo (($row['valor_actual'] * $row['porcentaje_interes']) / 100 ) ?></p>
                                                    <p class="card-text"><strong>Fecha de Ultimo Interés:</strong><?php echo $row['fecha_ultimo_interes'] ?></p>
                                                <?php } ?>

                                                <?php
                                                $proximaPagina = "";
                                                if (isset($_SESSION['PaginaAnteriorAuxiliar']) && $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/InterfazAdministrador.php") {
                                                    $proximaPagina = "../Vista/DeudasActivasAdmin.php";
                                                } else if (isset($_SESSION['PaginaAnteriorAuxiliar']) && $_SESSION['PaginaAnteriorAuxiliar'] == "../Vista/InterfazCliente.php") {
                                                    $proximaPagina = "../Vista/DeudasActivasCliente.php";
                                                }
                                                ?>

                                                <?php
                                            } if (isset($_POST['tipoNotificacion']) && ($_POST['tipoNotificacion'] == "1" )) {
                                                $estado = "";
                                                if (isset($row['estado']) && $row['estado'] == 0) {
                                                    $estado = "Aprovado";
                                                } else if (isset($row['estado']) && $row['estado'] == 1) {
                                                    $estado = "Pendiente";
                                                } else if (isset($row['estado']) && $row['estado'] == 2) {
                                                    $estado = "Rechazado";
                                                }
                                                ?>



                                                <h5 style="text-align: center;" class="card-title">Informacion actualizada  a fecha de <?php echo date('Y-m-d') ?> </h5>
                                                <p class="card-text"><strong>ID Deuda:</strong><?php echo $row['id_deuda'] ?> </p>
                                                <p class="card-text"><strong>ID Pago:</strong><?php echo $row['id_pago'] ?> </p>
                                                <p class="card-text"><strong>Valor Pago:</strong><?php echo $row['valor_pago'] ?></p>                        
                                                <p class="card-text"><strong>Estado Pago:</strong><?php echo $estado ?></p>                       
                                                <p class="card-text"><strong>Fecha Pago:</strong><?php echo $row['fecha_pago'] ?></p>
                                            <?php } ?>

                                            <form method="post" action="<?php echo $proximaPagina ?>">
                                                <button  type="submit" class="btn btn0 col text-center">Hacer un Pago</button>
                                            </form>
                                            <form method="post" action="<?php echo $_SESSION['PaginaAnteriorAuxiliar'] ?>">
                                                <button style="margin-top: 5px" type="submit" class="btn btn2 col text-center">Volver</button>
                                            </form>

                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function cambiarFoto() {
                                        // Aquí puedes implementar la lógica para cambiar la foto
                                        alert("Función para cambiar la foto");
                                    }

                                    function editarInformacion() {
                                        // Aquí puedes implementar la lógica para editar la información
                                        alert("Función para editar la información");
                                    }

                                    var bootstrapTimeout = setTimeout(loadLocalBootstrap, 3000); // 3 seconds

                                    function loadLocalBootstrap() {
                                        clearTimeout(bootstrapTimeout);
                                        var localBootstrap = document.getElementById('local-bootstrap');
                                        localBootstrap.removeAttribute('disabled');
                                    }

                                    function clearBootstrapTimeout() {
                                        clearTimeout(bootstrapTimeout);
                                    }


                                    document.addEventListener('DOMContentLoaded', function () {
                                        document.querySelectorAll('.mostrarComprovante').forEach(button => {
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
                                </script>

                                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                                </body>
                                </html>
