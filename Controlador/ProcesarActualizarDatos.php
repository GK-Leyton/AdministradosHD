<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set('America/Bogota');
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/ActualizarDatos.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarActualizarDatos.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";   
//require '../ConexionBD/conexion.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$modificador = new insertsUpdates();
if (isset($_POST['continuar'])) {
    $band = true;

    $correo = null;
    $palabra_segura = null;
    $contrasena = null;

    if (isset($_POST['correo']) && isset($_POST['correo2'])) {
        if ($_POST['correo'] == $_POST['correo2']) {
            $correo = $_POST['correo'];
        } else if ($band == true) {
            $band = false;
        }
    }
    if (isset($_POST['palabraSegura']) && isset($_POST['palabraSegura2'])) {
        if ($_POST['palabraSegura'] == $_POST['palabraSegura2']) {
            $palabra_segura = password_hash($_POST['palabraSegura'], PASSWORD_DEFAULT);
        } else if ($band == true) {
            $band = false;
        }
    }
    if (isset($_POST['contrasena']) && isset($_POST['contrasena2'])) {
        if ($_POST['contrasena'] == $_POST['contrasena2']) {
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
        } else if ($band == true) {
            $band = false;
        }
    }

    if ($band == true) {
        /* $sql = " UPDATE usuario
          SET correo = IFNULL(?, correo),
          palabra_segura = IFNULL(?, palabra_segura),
          contrasena = IFNULL(?, contrasena)
          WHERE id_usuario = ? ; ";
          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
          die("Error al preparar la consulta: " . $conn->error);
          }
          $stmt->bind_param("ssss", $correo , $palabra_segura , $contrasena , $_SESSION['id_usuario']);
         */
        $stmt = $modificador->EditarInformacionUsuarioPorId($correo, $palabra_segura, $contrasena, (isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : $_SESSION['id_usuario']));
        if ($stmt == true) {
            ?>
            <script>
                alert("Registro Completado");
                window.location.href = "<?php echo (isset($_SESSION['PaginaAnterior_Auxiliar']) ? $_SESSION['PaginaAnterior_Auxiliar'] : "../Controlador/ProcesarLogout.php"); ?>";
            </script> 
            <?php
            /////////////////////                                   
        } else {
            ?>
            <script>
                alert("Ocurrio un Problema");
                window.location.href = "<?php echo (isset($_SESSION['PaginaAnterior_Auxiliar']) ? $_SESSION['PaginaAnterior_Auxiliar'] : "../Controlador/ProcesarLogout.php"); ?>";
            </script> 
            <?php
        }
    } else {
        ?>
        <script>
            alert("Ocurrio un Problema");
            window.location.href = "<?php echo (isset($_SESSION['PaginaAnterior_Auxiliar']) ? $_SESSION['PaginaAnterior_Auxiliar'] : "../Controlador/ProcesarLogout.php"); ?>";
        </script> 
        <?php
    }
} else if (isset($_POST['volver'])) {
    ?>
    <script>
        window.location.href = "<?php echo (isset($_SESSION['PaginaAnterior_Auxiliar']) ? $_SESSION['PaginaAnterior_Auxiliar'] : "../Controlador/ProcesarLogout.php"); ?>";
    </script> 
    <?php
}
?>
