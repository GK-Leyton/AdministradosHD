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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazAdministrador.php") && ($_SESSION['PaginaAnterior'] != "../Vista/InsertarPrestamo.php") && ($_SESSION['PaginaAnterior'] != "../Vista/VerClientesAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarPrestamo.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/VerClientesAdmin.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";   


require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
//require '../ConexionBD/conexion.php';
/* $stmt = $conn->prepare("select * from usuario where tipo = 0;");
  $stmt->execute();
  $result = $stmt->get_result(); */
$result = $consulta->obtenerUsuarioPorTipo(0);
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
        <link rel="stylesheet" href="../Estilos/EstilosVerClientesAdmin.css">

        <link rel="stylesheet" href="../Estilos/BotonFlotanteArribaAbajo.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <body>
        <!-- Contenedor principal -->
        <div class="container align-content-center">
            <!-- Logo y Slogan -->
            <div class="row justify-content-center mt-3">    
                <div class="col-md-6 cen" >
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <a href="../Vista/InterfazAdministrador.php">
                            <img src="../imagenes/CredencialesAdministradosHD/Logo.png" alt="Logo" class="img-fluid" width="50">
                        </a>
                        <div class="slogan ml-auto">
                            <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Clientes.</p>
                        </div>

                </div>
            </div>
            <br>
            <br>
            <!-- Encabezado con título -->
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="slogan ml-auto">
                        <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;"> Nuestros colaboradores.</p>
                    </div>
                </div>
            </div>

            <!-- Tabla de deudas activas -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-10">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre Usuario</th>
                                    <th>ID Usuario</th>
                                    <th>Credencial Usuario</th>                                    
                                    <th>Tipo</th>                                    
                                    <th>Acciones</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Ejemplo de fila de deuda activa -->
                                <?php
                                if (($result->num_rows) > 0) {
                                    //while ($row = $result->fetch_assoc()) {
                                    while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {
                                        ?>

                                        <tr>
                                            <td><?php echo($row['nombre_usuario']) ?></td>
                                            <td><?php echo($row['id_usuario']) ?></td>
                                            <td><?php echo($row['credencial_usuario']) ?></td>
                                            <td><?php echo($row['tipo']) ?></td>
                                            <td>
                                                <form method="post" action="InsertarPrestamo.php">
                                                    <input type="hidden" value="<?php echo ($row['id_usuario']) ?>" name="idUsuario">   
                                                    <input type="hidden" value="<?php echo ($row['credencial_usuario']) ?>" name="credencialUsuario">   

                                                    <p>
                                                        <button class="btn btn1 btn-sm btn-block mt-1 hover-button">Prestar

                                                            <img class="hover-image profile-pic-circle" src="../FotosPerfil/Confirmadas/<?php echo (isset($row['foto_perfil']) && ($row['foto_perfil'] != null) ? $row['foto_perfil'] : "Predeterminada" ); ?>.png" alt="Descripción de la imagen">

                                                        </button>
                                                    </p>

                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Ejemplo de otra fila -->
                                    <?php }
                                } ?>
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
        <form action="../Vista/interfazAdministrador.php" method="post">    
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn2" name="Ingresar" value="Ingresar">Volver</button><!-- comment -->
            </div>
        </form> 
        <br>

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
