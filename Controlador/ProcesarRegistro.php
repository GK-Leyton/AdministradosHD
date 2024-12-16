<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/Registro.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarRegistro.php")) {
    // header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}

$_SESSION['PaginaAnterior'] = "../Controlador/ProcesarRegistro.php";
//require '../ConexionBD/conexion.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$modificador = new insertsUpdates();
require '../Modelo/ConsultasUsuarios.php';
$Consulta = new consultasUsuario();
if (isset($_POST['nombreUsuario']) && isset($_POST['nombreUsuario']) && isset($_POST['credencialUsuario']) && isset($_POST['contrasena']) && isset($_POST['contrasena2'])) {

    if ($_POST['contrasena'] == $_POST['contrasena2']) {
        /* $sql = "SELECT credencial_usuario FROM usuario WHERE credencial_usuario = '". $_POST['credencialUsuario'] . "';";
          $result = $conn->query($sql); */
        $result = $Consulta->ValidarCredencialUsuarioExistentePorCredencialUsuario($_POST['credencialUsuario']);
        if ($result->num_rows > 0) {
            ?>
            <script>
                alert("Datos Invalidos");
                //header("Location: ../Vista/Login.php");
                window.location.href = "../Vista/Login.php";

            </script>
            <?php
        } else {
            $contraSegura = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
            $palabraSegura = password_hash($_POST['palabra'], PASSWORD_DEFAULT);
            /* $sql = "INSERT INTO usuario (nombre_usuario , credencial_usuario , contrasena , palabra_segura)
              VALUES (?,?,?,?);";
              $stmt = $conn->prepare($sql);
              if ($stmt === false) {
              die("Error al preparar la consulta: " . $conn->error);
              }
              $stmt->bind_param("ssss", $_POST['nombreUsuario'], $_POST['credencialUsuario'], $contraSegura, $palabraSegura);
             */
            $stmt = $modificador->InsertarNuevoUsuario($_POST['nombreUsuario'], $_POST['credencialUsuario'], $contraSegura, $palabraSegura);
            if ($stmt == true) {
                ?>
                <script>
                    alert("Registro Completado");
                    window.location.href = "../Vista/Login.php";
                </script> 
                <?php
            }
        }
    }
} else {
    ?>
    <script>
        alert("Datos Invalidos");
        //header("Location: ../Vista/Login.php");
        window.location.href = "../Vista/Login.php";
    </script>
    <?php
}
?>
