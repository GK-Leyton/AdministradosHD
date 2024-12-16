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
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/InsertarPrestamo.php")) {
    //echo "<h1>LLendo a  " . $_SESSION['PaginaAnterior'] . "</h1>";
    header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarPrestamo.php";
}

//echo "<h1>" . $_SESSION['PaginaAnterior'] . "</h1>";
//require '../ConexionBD/conexion.php';
require '../Controlador/CreacionComprovantes.php';
require '../Modelo/ModificadoresInsertUpdate.php';
require '../Modelo/ConsultasUsuarios.php';
$consulta2 = new consultasUsuario();
$Consulta = new insertsUpdates();
if (isset($_POST['Prestar'])) {


    if ((isset($_POST['monto'])) && (($_POST['monto'] % 50) == 0) && ($_POST['monto'] >= 50)) {
        $interes = 10;
        $monto = $_POST['monto'];
        $monto_auxiliar = $monto;
        if (!isset($_POST['interesMensual'])) {
            $interes = 0;
            $monto = $monto + ($monto * 0.1);
        }

        $idU = $_POST['idUsuario2'];

        /////////////////////
        $fecha = date('Y-m-d');
//$fecha = null;
        /* $sql = "INSERT INTO deudas(valor_inicial , valor_actual , porcentaje_interes , id_usuario , interes , fecha_ultimo_interes , fecha_inicial , credencial_usuario, estado)
          VALUES (?, ? , ? , ? , 0 , ? , ? , ? , 1);";
          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
          die("Error al preparar la consulta: " . $conn->error);
          }
          $stmt->bind_param("sssssss", $monto, $monto, $interes, $idU, $fecha, $fecha, $_POST['credencialUsuario2']);
         */

//////////////////////////////////////////////////////
        $fecha = date('Y-m-d');
        $nombre_archivo = "";
        $band = false;
        $nombre_archivo2 = "";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener información del archivo subid11o
            $nombre_original = uniqid("");
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

            // Asegurarse de que la extensión sea PNG
            if ($extension != 'png') {
                // Intentar convertir la imagen al formato PNG
                $directorio_destino = "../ComprovantesDeuda/PorConfirmar/";
                $nombre_archivo = "Deuda" . $nombre_original . ".png";
                $nombre_archivo2 = "Deuda" . $nombre_original;

                // Obtener el tipo de imagen del archivo
                $tipo_imagen = exif_imagetype($_FILES['imagen']['tmp_name']);

                // Convertir si es necesario
                if ($tipo_imagen === IMAGETYPE_JPEG || $tipo_imagen === IMAGETYPE_PNG) {
                    // Crear una imagen desde el archivo subido
                    $imagen = null;
                    if ($tipo_imagen === IMAGETYPE_JPEG) {
                        $imagen = imagecreatefromjpeg($_FILES['imagen']['tmp_name']);
                    } elseif ($tipo_imagen === IMAGETYPE_PNG) {
                        $imagen = imagecreatefrompng($_FILES['imagen']['tmp_name']);
                    }

                    // Redimensionar la imagen a 600x500
                    $nueva_imagen = imagescale($imagen, 500, 600);

                    // Guardar como PNG en el directorio destino
                    if ($nueva_imagen !== false && imagepng($nueva_imagen, $directorio_destino . $nombre_archivo)) {
                        imagedestroy($nueva_imagen);
                        //echo "<script>alert('Imagen redimensionada y cargada como PNG con éxito');</script>";

                        $comprovant = new Comprovante();
                        $comprovant->aprovarComprovante($nombre_archivo2, false);
                        //echo "Conprovado";
                        $band = true;
                    } else {
                        //echo "<script>alert('Error al redimensionar y convertir la imagen a PNG');</script>";
                    }

                    // Liberar memoria
                    imagedestroy($imagen);
                } else {
                    //echo "<script>alert('Formato de imagen no soportado');</script>";
                }
            } else {
                // La imagen ya es PNG, proceder como antes
                $directorio_destino = "../ComprovantesDeuda/PorConfirmar/" . $nombre_archivo;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_destino)) {
                    $imagenCargada = true;
                    $_SESSION['imagenCargada'] = true;
                    //echo "<script>alert('Imagen PNG cargada con éxito');</script>";

                    $comprovant = new Comprovante();
                    $comprovant->aprovarComprovante($nombre_archivo2, false);
                    //echo "Conprovado";
                    $band = true;
                } else {
                    //echo "<script>alert('Error al cargar la imagen PNG');</script>";
                }
            }
        } else {
            $nombre_archivo2 = "Deuda" . uniqid("");
        }
//////////////////////////////////////////////////////        
        $stmt = $Consulta->InsertarDeuda($monto, $interes, $idU, $fecha, $_POST['credencialUsuario2'], $nombre_archivo2);
        //if ($stmt->execute() === true) {
        if ($stmt == true) {

            if (!$band) {
                $result = $consulta2->ObtenerIdDeudaPorComprovante($nombre_archivo2);
                if ($result->num_rows > 0) {
                    $row = $consulta2->obtenerDatosDeLasConsultas($result);

                    $comprovante = new Comprovante();
                    $comprovante->ComprovanteNoConfirmado($row['id_deuda'], $monto, $_POST['credencialUsuario2'], $fecha, $nombre_archivo2, false);
                    $comprovante->aprovarComprovante($nombre_archivo2, false);
                }
            }

            $result = $consulta2->ObtenerIdDeudaPorComprovante($nombre_archivo2);
            if ($result->num_rows > 0) {
                $row = $consulta2->obtenerDatosDeLasConsultas($result);
                $result2 = $consulta2->ObtenerInformacionDeudaParaCorreo($row['id_deuda']);
                if ($result2->num_rows > 0) {
                    $row2 = $consulta2->obtenerDatosDeLasConsultas($result2);
                    $rutaComprovante = "../ComprovantesDeuda/Aprovados/" . $nombre_archivo2 . ".png";
                    require '../Controlador/CorreoComprovanteDeuda.php';
                    CorreoComprovanteDeuda($row2['id_deuda'], $monto_auxiliar, $row2['valor_actual'], $row2['nombre_usuario'], $row2['correo'], $rutaComprovante);
                }
            }
            ?>
            <script>
                alert("Registro Completado1");
                window.location.href = "../Vista/VerClientesAdmin.php";
            </script> 
            <?php
            /////////////////////                                   
        } else {
            ?>
            <script>
                alert("Ocurrio un Problema2");
                window.location.href = "../Vista/VerClientesAdmin.php";
            </script> 
            <?php
        }
    } else {
        ?>
        <script>
            alert("Datos Invalidos3", );
            window.location.href = "../Vista/VerClientesAdmin.php";
        </script>        
        <?php
    }
} else if (isset($_POST['Volver'])) {
    //header("Location: ../Vista/VerClientesAdmin.php");
    ?><script>
        window.location.href = "../Vista/VerClientesAdmin.php";
    </script><?php
}
?>



