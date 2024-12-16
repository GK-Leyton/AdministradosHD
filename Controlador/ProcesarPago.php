<?php
if (!isset($_SESSION)) {
    session_start();
}
date_default_timezone_set('America/Bogota');
$auxiliarRuta = $_SESSION['PaginaAnterior'];
if (!isset($_SESSION['PaginaAnterior'])) {
    session_unset();
    // header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Vista/RealizarPagoCliente.php")) {
    //echo "<h1>redirigido desde " . $_SESSION['PaginaAnterior'] . "</h1>";
    //header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
}




$id_pago_auxiliar = "";
//require '../ConexionBD/conexion.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$consulta = new insertsUpdates();
require '../Controlador/CreacionComprovantes.php';
$comprovante = new Comprovante();
require '../Controlador/CorreoComprovantePago.php';

//echo"<h1>coco</h1>";
if ($_SESSION['PaginaAnterior'] == "../Vista/RealizarPagoAdmin.php") {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarPago.php";
    if ((($_POST['montoPago'] % 50) == 0) && ($_POST['montoPago'] <= $_POST['totalPagar2'] ) && ($_POST['montoPago'] > 0)) {

        /* $sql = "INSERT INTO pagos(valor_pago , id_deuda, fecha_pago , estado) 
          values
          ( ? , ? , ? , 0);";
          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
          die("Error al preparar la consulta: " . $conn->error);
          }
          $fecha = date('Y-m-d');
          $stmt->bind_param("sss", $_POST['montoPago'], $_POST['idDeuda2'], $fecha);
         */
        $fecha = date('Y-m-d');
        $nombre_archivo = "";
        $band = false;
        $nombre_archivo2 = "";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener información del archivo subido
            $nombre_original = uniqid("");
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            
            $nombre_archivo = "Pago" . $nombre_original . ".png";
            $nombre_archivo2 = "Pago" . $nombre_original;
            
            // Asegurarse de que la extensión sea PNG
            if ($extension != 'png') {
                // Intentar convertir la imagen al formato PNG
            $directorio_destino = "../ComprovantesPago/PorConfirmar/";

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
                        $band = true;
                    } else {
                        //echo "<script>alert('Error al redimensionar y convertir la imagen a PNG');</script>";
                    }

                    // Liberar memoria
                    imagedestroy($imagen);
                } else {
                    //echo "<script>alert('Formato de imagen no soportado');</script>";
                }
            }
                // La imagen ya es PNG, proceder como antes
                
            $directorio_destino = "../ComprovantesPago/Confirmados/" . $nombre_archivo;                                
            $directorio_origen = "../ComprovantesPago/PorConfirmar/" . $nombre_archivo;                                                
            echo"<h3>primero la ruta destino antes de mover la imagen es ".$directorio_destino."</h3>";
            echo"<h3>primero la ruta origen antes de mover la imagen es ".$directorio_origen."</h3>";
                if (rename($directorio_origen, $directorio_destino)) {
                    $imagenCargada = true;
                    $_SESSION['imagenCargada'] = true;
                    //echo "<script>alert('Imagen PNG cargada con éxito');</script>";
                    $band = true;
                } else {
                    //echo "<script>alert('Error al cargar la imagen PNG');</script>";
                }
        
            
        } else {
            $nombre_archivo2 = "Pago" . uniqid("");
        }
        
        $stmt = $consulta->InsertarPagos($_POST['montoPago'], $_POST['idDeuda2'], $fecha, 0, $nombre_archivo2);
        //if ($stmt->execute() === true) {
        if ($stmt == true) {
            //if (!$band) {
            require '../Modelo/ConsultasUsuarios.php';
            $consulta2 = new consultasUsuario();
            $result = $consulta2->ObtenerIdPagoPorComprovante($nombre_archivo2);
            if ($result->num_rows > 0) {
                $row = $consulta2->obtenerDatosDeLasConsultas($result);
                $id_pago_auxiliar = $row['id_pago'];
                if (!$band) {
                    $comprovante->ComprovanteNoConfirmado($row['id_pago'], $_POST['montoPago'], $_POST['idDeuda2'], $fecha, $nombre_archivo2, true);
                    $comprovante->aprovarComprovante($nombre_archivo2, true);
                }
            }


            if (($_POST['totalPagar2'] - $_POST['montoPago']) == 0) {
                /*               $sql2 = "update deudas
                  set estado = 0 ,  valor_actual = 0 , interes = 0
                  where id_deuda = ? ;";
                  $stmt = $conn->prepare($sql2);
                  if ($stmt === false) {
                  die("Error al preparar la consulta: " . $conn->error);
                  }
                  $stmt->bind_param("s", $_POST['idDeuda2']); */
                //if ($stmt->execute() === true) {
                $stmt = $consulta->PagoDeuda_CierreDeuda($_POST['idDeuda2']);
                if ($stmt == true) {

                    $res = $consulta2->ObtenerComprovantePorIdDeuda($_POST['idDeuda2']);
                    if ($res->num_rows > 0) {
                        $ro = $consulta2->obtenerDatosDeLasConsultas($res);

                        $comprovante->FinalizarDeudaComprovante($ro['comprovante_deuda']);
                    }
                    $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($id_pago_auxiliar);
                    if ($resultAuxiliar->num_rows > 0) {
                        $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                        $rutaArchivo = "../ComprovantesPago/Confirmados/" . $nombre_archivo2 . ".png";
                        CorreoComprovantePago("terminado", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                    }
                    ?>                                            

                    <script>
                        alert("Pago exitoso 333");
                        window.location.href = "../Vista/InterfazAdministrador.php";
                    </script> 
                    <?php
                }
            } else {
                $valorActual = $_POST['totalPagar2'] - $_POST['totalIntereses2'];
                $interes = $_POST['totalIntereses2'] - $_POST['montoPago'];
                if ($interes < 0) {
                    $valorActual = $valorActual + $interes;
                    /*                    $sql2 = "update deudas
                      set valor_actual = ? , interes = 0
                      where id_deuda = ? ;";

                      $stmt = $conn->prepare($sql2);
                      if ($stmt === false) {
                      die("Error al preparar la consulta: " . $conn->error);
                      }
                      $stmt->bind_param("ss", $valorActual, $_POST['idDeuda2']); */
                    $stmt = $consulta->PagoDeuda_CierreIntereses($_POST['idDeuda2'], $valorActual);
                    //if ($stmt->execute() === true) {
                    if ($stmt == true) {

                        $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($row['id_pago']);
                        if ($resultAuxiliar->num_rows > 0) {
                            $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                            $rutaArchivo = "../ComprovantesPago/Confirmados/" . $nombre_archivo2 . ".png";
                            CorreoComprovantePago(null, $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                        }
                        ?>

                        <script>
                            alert("Pago exitoso 2222");
                            window.location.href = "../Vista/InterfazAdministrador.php";
                        </script> 
                        <?php
                    }
                } else {
                    /*                    $sql2 = "update deudas
                      set  interes = ?
                      where id_deuda = ? ;";

                      $stmt = $conn->prepare($sql2);
                      if ($stmt === false) {
                      die("Error al preparar la consulta: " . $conn->error);
                      }
                      $stmt->bind_param("ss", $interes, $_POST['idDeuda2']); */
                    $stmt = $consulta->PagoDeuda_DecrementoInteres($interes, $_POST['idDeuda2']);
                    //if ($stmt->execute() === true) {
                    if ($stmt == true) {
                        $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($id_pago_auxiliar);
                        if ($resultAuxiliar->num_rows > 0) {
                            $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                            $rutaArchivo = "../ComprovantesPago/Confirmados/" . $nombre_archivo2 . ".png";
                            CorreoComprovantePago(null, $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                        }
                        ?>

                        <script>
                            alert("Pago exitoso 1111");
                            window.location.href = "../Vista/InterfazAdministrador.php";
                        </script> 
                        <?php
                    }
                }
            }
        }
    } else {
        ?>

        <script>
            alert("Dato Invalido");
            window.location.href = "../Vista/InterfazAdministrador.php";
        </script> 
        <?php
    }
} else if ($_SESSION['PaginaAnterior'] == "../Vista/RealizarPagoCliente.php") {
    //echo"<h1>coco</h1>";
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarPago.php";
    if ((($_POST['montoPago'] % 50) == 0) && ($_POST['montoPago'] <= $_POST['totalPagar2'] ) && ($_POST['montoPago'] > 0)) {
        $fecha = date('Y-m-d');
        //echo"<h1>hola</h1>";
        /*        $sql = "INSERT INTO pagos(valor_pago , id_deuda, fecha_pago , estado) 
          values
          ( ? , ? , ? , 1);";
          $stmt = $conn->prepare($sql);
          if ($stmt === false) {
          die("Error al preparar la consulta: " . $conn->error);
          }
          $fecha = date('Y-m-d');
          $stmt->bind_param("sss", $_POST['montoPago'], $_POST['idDeuda2'], $fecha); */
/////////////////////////////////////////
        $nombre_archivo = "";
        $band = false;
        $nombre_archivo2 = "";

        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            // Obtener información del archivo subido
            $nombre_original = uniqid("");
            $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            $nombre_archivo = "Pago" . $nombre_original . ".png";
            $nombre_archivo2 = "Pago" . $nombre_original;
            
            // Asegurarse de que la extensión sea PNG
            if ($extension != 'png') {
                // Intentar convertir la imagen al formato PNG
                $directorio_destino = "../Comprovantespago/PorConfirmar/";
                
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
                        $band = true;
                    } else {
                        //echo "<script>alert('Error al redimensionar y convertir la imagen a PNG');</script>";
                    }

                    // Liberar memoria
                    imagedestroy($imagen);
                } else {
                    //echo "<script>alert('Formato de imagen no soportado');</script>";
                }
            } 
                // La imagen ya es PNG, proceder como antes
                
                
                

            $directorio_destino = "../Comprovantespago/Confirmados/" . $nombre_archivo;
            $directorio_origen = "../Comprovantespago/PorConfirmar/" . $nombre_archivo;
            echo"<h3>segundo la ruta destino antes de mover la imagen es ".$directorio_destino."</h3>";
            echo"<h3>segundo la ruta origen antes de mover la imagen es ".$directorio_origen."</h3>";
                
                if (rename($directorio_origen, $directorio_destino)) {
                    $imagenCargada = true;
                    $_SESSION['imagenCargada'] = true;
                    //echo "<script>alert('Imagen PNG cargada con éxito');</script>";
                    $band = true;
                } else {
                    //echo "<script>alert('Error al cargar la imagen PNG');</script>";
                }
            
        } else {
            $nombre_archivo2 = "Pago" . uniqid("");
        }
////////////////////////////////////////////

        $stmt = $consulta->InsertarPagos($_POST['montoPago'], $_POST['idDeuda2'], $fecha, 1, $nombre_archivo2);

        if ($stmt == true) {

            if (!$band) {
                require '../Modelo/ConsultasUsuarios.php';
                $consulta2 = new consultasUsuario();
                $result = $consulta2->ObtenerIdPagoPorComprovante($nombre_archivo2);
                if ($result->num_rows > 0) {
                    $row = $consulta2->obtenerDatosDeLasConsultas($result);

                    $comprovante->ComprovanteNoConfirmado($row['id_pago'], $_POST['montoPago'], $_POST['idDeuda2'], $fecha, $nombre_archivo2, true);

                    $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($row['id_pago']);
                    if ($resultAuxiliar->num_rows > 0) {
                        $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                        $rutaArchivo = "../ComprovantesPago/PorConfirmar/" . $nombre_archivo2 . ".png";
                        CorreoComprovantePago("Pago_Cliente", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                        CorreoComprovantePago("Pago_Cliente_paraAdmin", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], "Administrados" , "respaldosadmdeudas@gmail.com" , $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                    }
                }
            }

            //echo"<h1>coco</h1>";
            ?>

            <script>
                alert("Se ha enviado el pago al area de validaciones");
                window.location.href = "../Vista/InterfazCliente.php";
            </script> 
            <?php
        }
    } else {
        ?>

        <script>
            alert("Valor invalido");
            window.location.href = "../Vista/InterfazCliente.php";
        </script> 
        <?php
    }
} else {
    ?>
    <script>
        alert("Este Pago Sera invalidado");
        window.location.href = "<?php echo $_SESSION['$auxiliarRuta']; ?>";
    </script>
    <?php
}
?>