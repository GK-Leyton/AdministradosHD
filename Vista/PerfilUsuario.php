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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazCliente.php") && ($_SESSION['PaginaAnterior'] != "../Vista/InterfazAdministrador.php") && ($_SESSION['PaginaAnterior'] != "../Vista/PerfilUsuario.php") && ($_SESSION['PaginaAnterior'] != "../Vista/AgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarTerminarAgregarFoto.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarActualizarDatos.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Vista/PerfilUsuario.php";
    $_SESSION['PaginaAnterior_Auxiliar'] = "../Vista/PerfilUsuario.php";
}


//echo "<h1>".$_SESSION['PaginaAnterior']." </h1>";
require '../Modelo/ConsultasUsuarios.php';
$Consulta = new consultasUsuario();
$result = $Consulta->ObtenerInfoUsuarioPorId($_SESSION['idUsuario']);
if ($result->num_rows > 0) {
    $row = $Consulta->obtenerDatosDeLasConsultas($result);
    
    $simbolo = ($_SESSION['TipoUsuario'] == 1) ? ">=" : "=";

    $result = $Consulta->ObtenerValorSumadoDeudasPorCredencialUsuario_y_EstadoActivo($simbolo, $row['credencial_usuario']);
    if ($result->num_rows > 0) {
        $row2 = $Consulta->obtenerDatosDeLasConsultas($result);
    }
    
    $result3 = $Consulta->ObtenerGananaciasDelDia();
    if($result3->num_rows > 0){
        $row3 = $Consulta->obtenerDatosDeLasConsultas($result3);
    }
}
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
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
        <link rel="stylesheet" href="../Estilos/EstilosPerfilUsuario.css" >

    </head>
    <body>
        <div class="container mt">

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
                                <p style="font-size: 1.5em; margin: 0 auto; color: black; font-weight: bold;">Perfil Usuario</p>
                            </div>
                            </div>

                            </div>
                            <div class="row">
                                <div class="col-md-4 text-center">

                                    <img src="../FotosPerfil/Confirmadas/<?php echo (isset($row['foto_perfil'])) ? $row['foto_perfil'] : "Predeterminada" ?>.png" class="col profile-pic-circle" alt="Foto de perfil">
                                    <div class="col card-body text-center">
                                        <form method="post" action="../Controlador/CambioFoto.php">
                                            <button type="submit" class="btn btn1" >Cambiar Foto</button>
                                        </form>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Información Básica</h5>
                                            <p class="card-text"><strong>Nombre:</strong>   <?php echo $row['nombre_usuario'] ?></p>
                                            <p class="card-text"><strong>Email:</strong>   <?php echo $row['correo'] ?></p>
                                            <p class="card-text"><strong>ID:</strong>   <?php echo $row['id_usuario'] ?></p>
                                            <p class="card-text"><strong>Credencial:</strong>   <?php echo $row['credencial_usuario'] ?></p>
                                            <p class="card-text"><strong><?php echo ($_SESSION['TipoUsuario'] == 1) ? "Total prestado:" : "Total en deuda:" ?></strong>   $<?php echo ($row2['total_sumado'] != null) ? $row2['total_sumado'] : 0 ?></p>
                                            <p class="card-text"><strong><?php echo ($_SESSION['TipoUsuario'] == 1) ? "Ganancias del dia:" : "" ?></strong>   <?php echo ($_SESSION['TipoUsuario'] == 1) ? "$".$row3['ganancia_diferencia'] : "" ?></p>
                                            <form method="post" action="../Vista/ActualizarDatos.php">
                                                <button  type="submit" class="btn btn2 col text-center">Editar Información</button>
                                            </form>
                                            <form method="post" action="<?php echo ($_SESSION['TipoUsuario'] == 1) ? "../Vista/InterfazAdministrador.php" : "../Vista/InterfazCliente.php" ?>">
                                                <button style="margin-top: 5px" type="submit" class="btn btn0 col text-center">Volver</button>
                                            </form>
                                        </div>
                                    </div>
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
                            </script>

                            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
                            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                            </body>
                            </html>
