<?php
require '../Modelo/ConsultasUsuarios.php';
if (!isset($_SESSION)) {
    session_start();
}



if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/Login.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarLogin.php")) {
    $auxiliarRuta = $_SESSION['PaginaAnterior'];
    //echo "<h1>lulo " . $_SESSION['PaginaAnterior'] . "</h1>";
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarLogin.php";
    //header("Location: " . $auxiliarRuta);
    ?><script>
        window.location.href = "<?php echo $auxiliarRuta; ?>";
    </script><?php
    exit();
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarLogin.php";
}

if (isset($_POST['Ingresar'])) {

    $consulta = new consultasUsuario();
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
//    $sql = "SELECT * FROM usuario WHERE credencial_usuario = '$usuario'";
//    $result = $conn->query($sql);
    $result = $consulta->obtenerUsuarioPorCredencial($usuario);

    if (($result->num_rows) > 0) {

        // $datos = $result->fetch_assoc();
        $datos = $consulta->obtenerDatosDeLasConsultas($result);

        if (password_verify($_POST['clave'], $datos['contrasena'])) {
            unset($_SESSION['inicio']);

            if (($datos['cedula'] == null) && ($datos['correo'] == null)) {
                $_SESSION['idUsuario'] = $datos['id_usuario'];
                ?>
                <script>
                    alert("Para terminar de hacer tu registro de manera satisfactoria, quisieramos pedirte confiarnos unos datos mas", );
                    window.location.href = "../Vista/DatosAdicionalesRegistro.php";
                </script>        
                <?php
            } elseif ($datos['foto_perfil'] == null) {
                $_SESSION['idUsuario'] = $datos['id_usuario'];
                //echo"coco"           
                ?>
                <script>
                    alert("Buenas nuevas, actualmente hay mas datos que nos encantaria recibir, por ello pedimos tu colaboracion");
                    window.location.href = "../Vista/AgregarFoto.php";
                </script>        
                <?php
            } else {
                if ($datos['tipo'] == 1) {
                    $_SESSION['TipoUsuario'] = 1;
                    $_SESSION['nombreUsuario'] = $datos['nombre_usuario'];
                    $_SESSION['idUsuario'] = $datos['id_usuario'];
                    $_SESSION['credenciaUsuario'] = $datos['credencial_usuario'];
                    //header("Location: ../Vista/InterfazAdministrador.php");
                    ?><script>
                        window.location.href = "../Vista/InterfazAdministrador.php";
                    </script><?php
                    exit;
                } else {
                    $_SESSION['TipoUsuario'] = 0;
                    $_SESSION['nombreUsuario'] = $datos['nombre_usuario'];
                    $_SESSION['idUsuario'] = $datos['id_usuario'];                                       
                    $_SESSION['credenciaUsuario'] = $datos['credencial_usuario'];
                    //header("Location: ../Vista/InterfazCliente.php");
                    ?><script>
                        window.location.href = "../Vista/InterfazCliente.php";
                    </script><?php
                    exit;
                }
            }
        } else {
            $_SESSION['idUsuario'] = $datos['id_usuario'];
            ?>        
            <script>
                alert("Datos Invalidos", );
                window.location.href = "../Vista/Login.php";
            </script>        
            <?php
        }
    }else{
        ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
    }
} else if (isset($_POST['Registrar'])) {
    // header("Location: ../Vista/Registro.php");
    ?><script>
        window.location.href = "../Vista/Registro.php";
    </script><?php
} else if (isset($_POST['Editar'])) {
    // header("Location: ../Vista/ConfirmarEditar.php");
    ?><script>
        window.location.href = "../Vista/ConfirmarEditar.php";
    </script><?php
} else {
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
?>




