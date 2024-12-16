<?php
if (!isset($_SESSION)) {
    session_start();
    $band = false;
}
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if ((isset($_SESSION['PaginaAnterior'])) && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto_Predeterminadas.php") && ($_SESSION['PaginaAnterior'] != "../Vista/TerminarAgregarFoto.php")) {
    //echo "<h1>Redirigido a ".$_SESSION['PaginaAnterior']."</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarTerminarAgregarFoto.php";
}
//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";
require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
$nombreImagen = "";
if (isset($_POST['cargarImagen'])) {
    if (isset($_SESSION['auxImagenCargada']) && $_SESSION['auxImagenCargada'] == true) {
        $largo = strlen($_SESSION['nombreImagen']);
        $auxNombre = substr($_SESSION['nombreImagen'], 0, -4);
        $nombreImagen = ((isset($_SESSION['PaginaAnterior_Auxiliar'])) && ($_SESSION['PaginaAnterior_Auxiliar'] == "../Vista/PerfilUsuario.php")) ? $_SESSION['foto_perfil'] : uniqid($auxNombre);
        $directorio_destino = '../FotosPerfil/Confirmadas/' . $nombreImagen . ".png";
        if (rename($_SESSION['directorioActual'], $directorio_destino)) {
            //echo "La imagen se ha movido correctamente.";
            $band = true;

            //echo "id del loquito " . $_SESSION['idUsuario'];
            //echo "Nombre de la imagen" . $nombreImagen;
        } else {
            $band = 0;
            unlink($_SESSION['directorioActual']);
            ?>
            <script>
                alert("Ha ocurrido un error al cargar la imagen");
                window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            alert("No se cargó una imagen");
            window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
        </script>
        <?php
    }
} else if (isset($_POST['cargarImagenPredeterminada'])) {

    $band = true; // para verificar si viene desde imagenes predeterminadas
    $band2 = false; //para verificar si tiene una imagen personalizada y quiere ahora una imagen predeterminada
    $result = $consulta->ObtenerFotoPerfilPorIdUsuario($_SESSION['idUsuario']);
    if ($result->num_rows > 0) {
        $row = $consulta->obtenerDatosDeLasConsultas($result);

        // Agregamos depuración
        echo '<pre>';
        var_dump($row['foto_perfil']);
        echo '</pre>';

        for ($i = 0; $i < 16; $i++) {
            //echo"<h1>fotoPerfil" . ($i + 1) . " </h1>";
            if ($row['foto_perfil'] == "fotoPerfil" . ($i + 1)) {
                $band2 = true;
                break;
            }
        }
    }
    ?>
    <script>
        alert("<?php echo $row['foto_perfil'] ?>");
    </script>
    <?php
    if ($band2 == false) {
        $imagePath = '../FotosPerfil/Confirmadas/' . $row['foto_perfil'] . ".png";

        // Verifica si el archivo existe antes de intentar eliminarlo
        if (file_exists($imagePath)) {
            // Intenta eliminar el archivo
            if (unlink($imagePath)) {
                echo "La imagen se ha eliminado correctamente.";
            } else {
                echo "Hubo un problema al intentar eliminar la imagen.";
            }
        } else {
            echo "El archivo no existe.";
        }
    }














    $nombreImagen = $_POST['opcion'];
    //echo"estado " . $band;
}

if ($band) {
    require '../Modelo/ModificadoresInsertUpdate.php';
    $modificador = new insertsUpdates();
    $stmt = $modificador->ActualizarFotoPerfilPorId($_SESSION['idUsuario'], $nombreImagen);
    if ($stmt == null) {
        ?>
        <script>
            alert("Ocurrio un error al cargar la imagen");
            window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
        </script> 
        <?php
    } else {
        ?>
        <script>
            alert("Imagen actualizada satisfactoriamente");
            window.location.href = "<?php echo (isset($_SESSION['PaginaAnterior_Auxiliar']) ? $_SESSION['PaginaAnterior_Auxiliar'] : "../Vista/Login.php" ); ?>";
        </script> 
        <?php
    }
} else if (isset($_POST['volver'])) {
    ?>
    <script>
        window.location.href = "../Vista/AgregarFoto.php";
    </script> 
    <?php
}
?>

