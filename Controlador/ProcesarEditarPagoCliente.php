<?php
if (!isset($_SESSION)) {
    session_start();
}

date_default_timezone_set('America/Bogota');
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/EditarPagoCliente.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarEditarPagoCliente.php")) {
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarEditarPagoCliente.php";
}

require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();

//require '../ConexionBD/conexion.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$modificador = new insertsUpdates();
$informacionDeuda = explode("-", $_POST['select1']);

/*
  $pago = (!isset($_POST['ValorPagoNuevo'])) ? 0 : $_POST['ValorPagoNuevo'];
  $id_deuda = ($informacionDeuda[0] == "") ? 0 : $informacionDeuda[0];
  $total_deuda = ($informacionDeuda[1] == "") ? 0 : $informacionDeuda[1];
  $id_pago =  $informacionDeuda[2];
 */

$pago = (!isset($_POST['ValorPagoNuevo'])) ? 0 : $_POST['ValorPagoNuevo'];
$id_deuda = (!isset($informacionDeuda[0])) ? 0 : $informacionDeuda[0];
$total_deuda = (!isset($informacionDeuda[1])) ? 0 : $informacionDeuda[1];
$id_pago = (!isset($informacionDeuda[2])) ? 0 : $informacionDeuda[2];
$nombre_archivo2 = "";
$band = false;
//echo ("Pago nuevo " . $pago);
//echo (" Id deuda " . $id_deuda);
//echo (" Total deuda  " . $total_deuda);
//echo (" Id Pago  " . $id_pago);
if (isset($_POST['continuar'])) {
    //echo "<h1>coco 1</h1>";
    if (($pago == 0) || ((($pago % 50) == 0) && ($pago <= $total_deuda ) && ($pago > 0) && isset($_POST['continuar']))) {
        //echo "<h1>coco 2</h1>";

        $result = $consulta->ObtenerComprovantePorIdPago($id_pago);
        if ($result->num_rows > 0) {
            $row = $consulta->obtenerDatosDeLasConsultas($result);
            $rutaImagen = "../ComprovantesPago/PorConfirmar/" . $row['comprovante_pago'] . ".png";
            if ($row['comprovante_pago'] != "sin_comprovante") {
                $nombre_archivo2 = $row['comprovante_pago'];
                if (file_exists($rutaImagen)) {
                    if (unlink($rutaImagen)) {
                        //echo "La imagen ha sido borrada exitosamente";
                    } else {
                        //echo "No se pudo borrar la imagen";
                    }
                }
            } else {
                $nombre_archivo2 = "Pago" . uniqid("");
            }
        }

        $pago = ($pago == 0) ? null : $pago;
        $id_deuda = ($id_deuda == 0) ? null : $id_deuda;
        /* $sql = "update pagos 
          set valor_pago = IFNULL(? , valor_pago) , id_deuda = IFNULL(? ,id_deuda)
          where id_pago = ?;";
          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
          die("Error al preparar la consulta: " . $conn->error);
          }
          $stmt->bind_param("sss", $pago ,$id_deuda ,$id_pago);
         */
        $stmt = $modificador->EditarPagoPorId($pago, $id_deuda, $id_pago, $nombre_archivo2);
        if ($stmt == false) {
            ?>
            <script>
                alert("Ocurrio algun error con tu consulta");
                window.location.href = "../Vista/InterfazCliente.php";
            </script>    
            <?php
        } else {
////////////////////////////////////////////////////


            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Obtener información del archivo subid11o
                $nombre_original = $nombre_archivo2;
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);

                // Asegurarse de que la extensión sea PNG
                if ($extension != 'png') {
                    // Intentar convertir la imagen al formato PNG
                    $directorio_destino = "../ComprovantesPago/PorConfirmar/";
                    $nombre_archivo = $nombre_original . ".png";

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
                            echo "<script>alert('Imagen redimensionada y cargada como PNG con éxito');</script>";
                            require '../Controlador/CreacionComprovantes.php';
                            $comprovant = new Comprovante();
                            $comprovant->aprovarComprovante($nombre_archivo2, false);
                            echo "Conprovado";
                            $band = true;
                        } else {
                            echo "<script>alert('Error al redimensionar y convertir la imagen a PNG');</script>";
                        }

                        // Liberar memoria
                        imagedestroy($imagen);
                    } else {
                        echo "<script>alert('Formato de imagen no soportado');</script>";
                    }
                } else {
                    // La imagen ya es PNG, proceder como antes
                    $directorio_destino = "../ComprovantesPago/PorConfirmar/" . $nombre_archivo;
                    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $directorio_destino)) {
                        $imagenCargada = true;
                        $_SESSION['imagenCargada'] = true;
                        echo "<script>alert('Imagen PNG cargada con éxito');</script>";
                        $band = true;
                    } else {
                        echo "<script>alert('Error al cargar la imagen PNG');</script>";
                    }
                }
            }
////////////////////////////////////////////////////

            if (!$band) {

                $result2 = $consulta->ObtenerInformacionPagoPorId($id_pago);
                if ($result2->num_rows > 0) {
                    $row2 = $consulta->obtenerDatosDeLasConsultas($result2);
                    ?>
                    <script>
                        alert("Valio monda");

                    </script>    
                    <?php
                    require '../Controlador/CreacionComprovantes.php';
                    $comprovante = new Comprovante();
                    $comprovante->ComprovanteNoConfirmado($row2['id_pago'], $row2['valor_pago'], $row2['id_deuda'], $row2['fecha_pago'], $nombre_archivo2, true);
                }
            }
            ?>    
            <script>
                alert("Actualizacion Exitosa");
                window.location.href = "../Vista/InterfazCliente.php";
            </script>    
            <?php
        }
    } else {
        ?>
        <script>
            alert("Informacion no valida");
            window.location.href = "../Vista/InterfazCliente.php";
        </script>    
        <?php
    }
} else if (isset($_POST['volver'])) {
    // header("location: ../Vista/VerPagosCliente.php");
    ?><script>
        window.location.href = "../Vista/VerPagosCliente.php";
    </script><?php
} else {
    ?>
    <form action="../Vista/EditarPagoCliente.php" id="formulario1" method="post">
        <input type="hidden" name="idPago" value="<?php echo $informacionDeuda[0] ?>">
    </form>    
    <script>

        function enviarFormulario() {
            alert("Datos Invalidos");
            document.getElementById("formulario1").submit();
        }
        enviarFormulario();

    </script> 
    <?php
}
 