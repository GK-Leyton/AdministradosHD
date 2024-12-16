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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasActivasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/DeudasFinalizadasCliente.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarPago.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosCliente.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarEditarPagoCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/PerfilUsuario.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerNotificacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerComprovantePago.php") && ($_SESSION['PaginaAnterior'] != "../Vista/MasInformacion.php") && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/PerfilUsuario.php")) {
    echo "<h1>LLendo a  " . $_SESSION['PaginaAnterior'] . "</h1>";
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/InterfazCliente.php";
    $_SESSION['PaginaAnteriorAuxiliar'] = "../Vista/InterfazCliente.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";   
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <link id="local-bootstrap" rel="stylesheet" href="../Estilos/EstilosInterfazCliente.css">
        <link rel="preload" href="../Estilos/estilosLocales.css" as="style" onload="this.rel = 'stylesheet'">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" onerror="loadLocalBootstrap()">
        <link rel="stylesheet" href="../Estilos/estilosLocales.css" disabled>



        <?php
        require '../Modelo/ConsultasUsuarios.php';
        $consulta = new consultasUsuario();
        $result0 = $consulta->ObtenerCantidadNotificacionesActivasUsuario($_SESSION['idUsuario']);
        if ($result0->num_rows > 0) {
            $row0 = $consulta->obtenerDatosDeLasConsultas($result0);
            if ($row0['cantidad'] > 0) {
                ?>
                <style>
                    .floating-button {
                        color: white;
                        padding: 1em;
                        border-radius: 50%;
                        cursor: pointer;
                        box-shadow: 0 4px 8px gold;
                        transition: background-color 0.3s;
                        position: relative;
                    }

                    .red-dot{
                        display: flex;
                        justify-content: center; /* Centra horizontalmente */
                        align-items: center; /* Centra verticalmente */
                        position: absolute;
                        top: 1em;
                        right: 1em;
                        position: absolute;
                        width: 0.8em; /* Ajusta el tamaño del punto */
                        height: 0.8em; /* Ajusta el tamaño del punto */
                        background-color: red;
                        box-shadow: 0 0 0 2px red;
                        border-radius: 50%;


                    }
                </style>
                <?php
            }
        }
        ?>


        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página del Usuario</title>
        <!-- Bootstrap CSS -->



    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container">
            <!-- Logo -->
            <!-- Menú -->
            <div class="row justify-content-center mt-3">
                <div class="col-md-9">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">

                        <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">               

                        <div class="campana-padre ">
                            <div style="align-content: center;" class="floating-button campana" id="notificationButton">
                                🔔
                                <div class="red-dot">
                                    <div class="noti"><?php echo $row0['cantidad'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="notification-container" id="notificationContainer">

                            <div class="notification-header">
                                <button id="list1Button" >Aumento Intereses</button>
                                <button id="list2Button" >Pagos</button>
                            </div>

                            <?php
                            $result = $consulta->ObtenerNotificacionesUsuario($_SESSION['idUsuario']);
                            $result2 = $consulta->ObtenerNotificacionesPagos_ParaElCliente($_SESSION['idUsuario']);
                            echo '<div id="list1" class="notification-list">';
                            if ($result->num_rows > 0) {
                                while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {
                                    ?>
                                    <form id="formulario<?php echo $row['id_notificacion'] ?>" action="../Vista/VerNotificacion.php" method="post">
                                        <input style="display:none;" type="hidden" name="idNotificacion" value="<?php echo $row['id_notificacion'] ?>">
                                        <input style="display:none;" type="hidden" name="tipoNotificacion" value="0">
                                        <?php
                                        echo "<div " . ($row['estado'] == 1 ? "style='background-color: #AFE6FF; font-weight: bold;'" : '') . " data-form-id='formulario" . $row['id_notificacion'] . "' class='notification'>Tu deuda con id " . $row['id_externo'] . "  acaba de aumentar su interés. <small style='float: right; font-size: 0.7em;'>" . $row['fecha'] . "</small> </div>";
                                        ?>      
                                    </form>
                                        <?php
                                    }
                                } else {
                                    echo "<div class='notification'>No hay notificaciones</div>";
                                }
                                echo '</div>';

                                echo '<div id="list2" class="notification-list">';
                                if ($result2->num_rows > 0) {
                                    while ($row2 = $consulta->obtenerDatosDeLasConsultas($result2)) {
                                        ?>
                                    <form id="formulario<?php echo $row2['id_notificacion'] ?>" action="../Vista/VerNotificacion.php" method="post">


                                        <input style="display:none;" type="hidden" name="idNotificacion" value="<?php echo $row2['id_notificacion'] ?>">
                                        <input style="display:none;" type="hidden" name="tipoNotificacion" value="1">
        <?php
        $result3 = $consulta->ObtenerTipoUsuarioPorId($row2['id_update']);
        if ($result3->num_rows > 0) {
            $row3 = $consulta->obtenerDatosDeLasConsultas($result3);
            $mensaje = (isset($row3['tipo']) && $row3['tipo'] == 0) ? 'ser evaluada por el area financiera' : 'actualizarse';
            echo "<div " . ($row2['estado'] == 1 ? "style='background-color: #AFE6FF; font-weight: bold;'" : '') . " data-form-id='formulario" . $row2['id_notificacion'] . "' class='notification'>Tu pago con id " . $row2['id_externo'] . " acaba de " . $mensaje . ". <small style='float: right; font-size: 0.7em;'>" . $row2['fecha'] . "</small></div>";
        }
        ?>      
                                    </form>
                                        <?php
                                    }
                                } else {
                                    echo "<div class='notification'>No hay notificaciones</div>";
                                }
                                echo '</div>';
                                ?>    


                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="DeudasActivasCliente.php"><div class="texto">Deudas Activas</div></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="DeudasFinalizadasCliente.php"><div class="texto">Deudas Finalizadas</div></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="VerPagosCliente.php"><div class="texto">Histrorial de Pagos</div></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Vista/PerfilUsuario.php"><div class="texto">Perfil Usuario</div></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="../Controlador/ProcesarLogout.php"><div class="texto">Cerrar Sesion</div></a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </div>
            </div>

            <!-- Contenido de la página -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <h2>Bienvenido, <?php echo($_SESSION['nombreUsuario']) ?></h2>
                    <em>
                        <p>Siempre estamos en busqueda de tu comodida, por eso te presentamos la posibilidad de tener un seguimiento de tus deudas por tu propia cuenta.</p>
                        <p>por que nacimos para servir.</p>
                    </em>
                </div>
            </div>

            <!-- Carrusel de Imágenes -->
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div id="carruselDeImagenes" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carruselDeImagenes" data-slide-to="0" class="active"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="1"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="2"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="3"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="4"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="5"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="6"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="7"></li>
                            <li data-target="#carruselDeImagenes" data-slide-to="8"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel1.jfif" class="d-block w-100 promo" alt="Imagen 1">
                                <p class="texto-superpuesto">Prestamos Rápidos.</p>

                            </div>                            
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel10.png" class="d-block w-100 promo" alt="Imagen 4">                                                                                    
                                                        
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>                            
                                <img src="../imagenes/Carrusel/carrusel3.jfif" class="d-block w-100 promo" alt="Imagen 3">                                                                                        
                                <p class="texto-superpuesto">Disponibilidad de Pago.</p>                            
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel9.png" class="d-block w-100 promo" alt="Imagen 4">                                                                                    
                                
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel4.jfif" class="d-block w-100 promo" alt="Imagen 4">                                                                                    
                                <p class="texto-superpuesto">Fácil Aprobación.</p>                            
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel8.png" class="d-block w-100 promo" alt="Imagen 4">                                                                                    
                                
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel2.jfif" class="d-block w-100 promo" alt="Imagen 2">
                                <p class="texto-superpuesto">Intereses Razonables.</p>

                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel6.png" class="d-block w-100 promo" alt="Imagen 4">                                                                                                                                            
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel5.jfif" class="d-block w-100 promo" alt="Imagen 4">                                                                                                                                            
                                <p class="texto-superpuesto">Gestion Transparente.</p>
                            </div>
                            <div class="carousel-item">
                                <h5>Si puedes pagarlo, puedo prestarlo</h5>
                                <img src="../imagenes/Carrusel/carrusel7.png" class="d-block w-100 promo" alt="Imagen 4">                                                                                                                    
                            </div>
                            
                            
                            
                        </div>
                        <a class="carousel-control-prev" href="#carruselDeImagenes" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carruselDeImagenes" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Siguiente</span>
                        </a>
                    </div>
                </div>
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




                document.getElementById('notificationButton').addEventListener('click', function () {
                    var container = document.getElementById('notificationContainer');
                    var button = document.getElementById('notificationButton');
                    var redDot = document.querySelectorAll('.red-dot');
                    if (container.style.display === 'none' || container.style.display === '') {
                        container.style.display = 'block';
                        button.style.boxShadow = '0 3px 4px blue';


                    } else {
                        container.style.display = 'none';
                        button.style.boxShadow = 'none';

                    }
                });


                document.addEventListener('DOMContentLoaded', function () {
                    // Obtener todos los divs con la clase 'notification'
                    const notifications = document.querySelectorAll('.notification');

                    notifications.forEach(function (notification) {
                        // Agregar un listener de clic a cada div
                        notification.addEventListener('click', function () {
                            // Obtener el id del formulario asociado usando el atributo data-form-id
                            const formId = notification.getAttribute('data-form-id');
                            const form = document.getElementById(formId);

                            // Enviar el formulario
                            if (form) {
                                form.submit();
                            }
                        });
                    });
                });

                document.getElementById('list1Button').addEventListener('click', function () {
                    document.getElementById('list1').style.display = 'block';
                    document.getElementById('list2').style.display = 'none';
                    document.getElementById('list1Button').classList.add('active');
                    document.getElementById('list2Button').classList.remove('active');
                });

                document.getElementById('list2Button').addEventListener('click', function () {
                    document.getElementById('list1').style.display = 'none';
                    document.getElementById('list2').style.display = 'block';
                    document.getElementById('list2Button').classList.add('active');
                    document.getElementById('list1Button').classList.remove('active');
                });






                document.addEventListener('DOMContentLoaded', function () {
                    // Inicializa el estado de las listas
                    document.getElementById('list1').style.display = 'block';
                    document.getElementById('list2').style.display = 'none';

                    document.getElementById('list1Button').addEventListener('click', function () {
                        document.getElementById('list1').style.display = 'block';
                        document.getElementById('list2').style.display = 'none';
                        document.getElementById('list1Button').classList.add('active');
                        document.getElementById('list2Button').classList.remove('active');
                    });

                    document.getElementById('list2Button').addEventListener('click', function () {
                        document.getElementById('list1').style.display = 'none';
                        document.getElementById('list2').style.display = 'block';
                        document.getElementById('list2Button').classList.add('active');
                        document.getElementById('list1Button').classList.remove('active');
                    });
                });

            </script>


            <footer class="footer">
                <p>&copy; <?php echo date('Y') ?> Administrados HD. Todos los derechos reservados.</p>
                <p>CLL 68 A SUR # 18 X 62, Bogotá, Colombia</p>
                <p>Email: <a href="mailto:admdeudas@gmail.com">admdeudas@gmail.com</a> | Celular: 3142716310</p>                
            </footer>
        </div>
    </body>
</html>
