<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set('America/Bogota');
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/DatosAdicionalesRegistro.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarDatosAdicionalesRegistro.php";
}






//require '../ConexionBD/conexion.php';

require '../Modelo/ModificadoresInsertUpdate.php';
$modificador = new insertsUpdates();

if (isset($_POST['Registrar'])) {



    /* $sql = "UPDATE usuario
      set cedula = ? , correo = ?
      where id_usuario = ?;";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
      die("Error al preparar la consulta: " . $conn->error);
      }
      $stmt->bind_param("sss", $_POST['cedula'] , $_POST['email'] , $_SESSION['idUsuario']); */
    $stmt = $modificador->ActualizarCedula_y_Correo_PrimeraVez($_POST['cedula'], $_POST['email'], $_SESSION['idUsuario']);
    if ($stmt == true) {
        ?>
        <script>
            alert("Registro Completado");
            alert("Buenas nuevas, actualmente hay mas datos que nos encantaria recibir, por ello pedimos tu colaboracion");
            window.location.href = "../Vista/AgregarFoto.php";
        </script>        
        <?php
    }
} else {
    ?>
    <script>
        alert("Ocurrio un error");
        window.location.href = "../Vista/Login.php";
    </script> 
    <?php
}