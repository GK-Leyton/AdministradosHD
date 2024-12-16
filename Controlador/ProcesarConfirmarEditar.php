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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/ConfirmarEditar.php") && ($_SESSION['PaginaAnterior'] != "../Modelo/ProcesarConfirmarEditar.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}


$_SESSION['PaginaAnterior'] = "../Controlador/ProcesarConfirmarEditar.php";

//require '../ConexionBD/conexion.php';
require '../Modelo/ConsultasUsuarios.php';
$Consulta = new consultasUsuario();

if (isset($_POST['continuar'])) {
    /*    $sql = "SELECT palabra_segura , nombre_usuario , id_usuario FROM usuario WHERE cedula = " . $_POST['documento'] . ";";
      $result = $conn->query($sql);
     */
    $result = $Consulta->ObtenerCredencialesUsuarioPorDocumento($_POST['documento']);
    if ($result->num_rows > 0) {

        $datos = $Consulta->obtenerDatosDeLasConsultas($result);

        if ($datos) {
            if (password_verify($_POST['palabraSegura'], $datos['palabra_segura'])) {
                $_SESSION['nombre'] = $datos['nombre_usuario'];
                $_SESSION['id_usuario'] = $datos['id_usuario'];
                //header("Location: ../Vista/ActualizarDatos.php");
                ?><script>
                    window.location.href = "../Vista/ActualizarDatos.php";
                </script><?php
            } else {
                ?>
                <script>
                    alert("Datos Invalidos", );
                    window.location.href = "../Vista/Login.php";
                </script>        
                <?php
            }
        }
    } else {
        ?>
        <script>
            alert("Datos Invalidos", );
            window.location.href = "../Vista/Login.php";
        </script>        
        <?php
    }
} else if (isset($_POST['volver'])) {
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
} else {
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
?>


