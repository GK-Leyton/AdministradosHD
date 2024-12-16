<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!isset($_SESSION['PaginaAnterior'])) || (isset($_SESSION['PaginaAnterior']) && $_SESSION['PaginaAnterior'] == "../Vista/Login.php")) {
    session_unset();
    //header("Location: ../Vista/Login.php");
    ?><script>
        window.location.href = "../Vista/Login.php";
    </script><?php
}
if (isset($_SESSION['PaginaAnterior']) && ($_SESSION['PaginaAnterior'] != "../Vista/VerPagosAdmin.php") && ($_SESSION['PaginaAnterior'] != "../Controlador/ProcesarEstadoPagos.php")) {
//echo "<h1>LLendo a  ".$_SESSION['PaginaAnterior']."</h1>";          
//header("Location: " . $_SESSION['PaginaAnterior']);
    ?><script>
        window.location.href = "<?php echo $_SESSION['PaginaAnterior']; ?>";
    </script><?php
} else {
    $_SESSION['PaginaAnterior'] = "../Controlador/ProcesarEstadoPagos.php";
}

//echo "<h1>".$_SESSION['PaginaAnterior']."</h1>";   
//require '../ConexionBD/conexion.php';
require '../Modelo/ModificadoresInsertUpdate.php';
$modificador = new insertsUpdates();
require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
$consulta2 = new consultasUsuario();
require '../Controlador/CorreoComprovantePago.php';
require '../Controlador/CreacionComprovantes.php';
$comprovante = new Comprovante();
if (isset($_POST['aceptar'])) {

    /* $sql = "update pagos
      set estado = 0
      where id_pago = ".$_POST['idPago'].";";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
      die("Error al preparar la consulta: " . $conn->error);
      } */
    $stmt = $modificador->AceptarPagoPorId($_POST['idPago']);
    if ($stmt == false) {
        ?>

        <script>
            alert("Ha ocurrido un error");
            window.location.href = "../Vista/VerPagosAdmin.php";
        </script> 
        <?php
    } else {


        $result = $consulta->ObtenerComprovantePorIdPago($_POST['idPago']);
        if ($result->num_rows > 0) {
            $row = $consulta->obtenerDatosDeLasConsultas($result);

            $comprovante->aprovarComprovante($row['comprovante_pago'], true);
            //echo ("coco".$row['comprovante_pago']);
            ?>

            <script>
            //alert("Ha");

            </script> 
            <?php
        }


        /* $stmt = $conn->prepare("select valor_actual as total_pagar , (valor_actual + interes) as total_pagar2 from deudas where id_deuda = ".$_POST['idDeuda']." ;");
          $stmt->execute();
          $result = $stmt->get_result(); */
        $result = $consulta->ObtenerValorActual_y_TotalPagar_PorIdDeuda($_POST['idDeuda']);
        if (($result->num_rows) > 0) {
            $row = $consulta->obtenerDatosDeLasConsultas($result);

            /* $stmt = $conn->prepare("select interes from deudas where id_deuda = ".$_POST['idDeuda']." ;");
              $stmt->execute();
              $result2 = $stmt->get_result(); */
            $result2 = $consulta->ObtenerInteresPorIdDeuda($_POST['idDeuda']);
            if (($result2->num_rows) > 0) {
                $row2 = $consulta->obtenerDatosDeLasConsultas($result2);
                $total_pagar = $row['total_pagar'];
                $total_pagar2 = $row['total_pagar2'];

                if ((($_POST['montoPago'] % 50) == 0) && ($_POST['montoPago'] <= $total_pagar2 ) && ($_POST['montoPago'] > 0)) {


                    if (($total_pagar2 - $_POST['montoPago']) == 0) {
                        /* $sql2 = "update deudas
                          set estado = 0 ,  valor_actual = 0 , interes = 0
                          where id_deuda = ? ;";
                          $stmt = $conn->prepare($sql2);
                          if ($stmt === false) {
                          die("Error al preparar la consulta: " . $conn->error);
                          }
                          $stmt->bind_param("s",$_POST['idDeuda']); */
                        $stmt = $modificador->PagoDeuda_CierreDeuda($_POST['idDeuda']);
                        if ($stmt == true) {
                            $consulta = new consultasUsuario();
                            $res = $consulta->ObtenerComprovantePorIdDeuda($_POST['idDeuda']);
                            if ($res->num_rows > 0) {
                                $ro = $consulta->obtenerDatosDeLasConsultas($res);

                                $comprovante->FinalizarDeudaComprovante($ro['comprovante_deuda']);

                                $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($_POST['idPago']);
                                if ($resultAuxiliar->num_rows > 0) {
                                    $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                                    $rutaArchivo = "../ComprovantesPago/Confirmados/" . $rowAuxiliar['comprovante_pago'] . ".png";
                                    CorreoComprovantePago("terminado_aceptado", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                                }
                            }
                            ?>


                            <script>
                                alert("Pago exitoso");
                                window.location.href = "../Vista/VerPagosAdmin.php";
                            </script> 
                            <?php
                        }
                    } else {
                        $interes = $row2['interes'] - $_POST['montoPago'];
                        if ($interes < 0) {
                            $valorActual = $total_pagar + $interes;
                            /* $sql2 = "update deudas
                              set valor_actual = ? , interes = 0
                              where id_deuda = ? ;";

                              $stmt = $conn->prepare($sql2);
                              if ($stmt === false) {
                              die("Error al preparar la consulta: " . $conn->error);
                              }
                              $stmt->bind_param("ss", $valorActual , $_POST['idDeuda']); */
                            $stmt = $modificador->PagoDeuda_CierreIntereses($_POST['idDeuda'], $valorActual);
                            if ($stmt == true) {

                                $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($_POST['idPago']);
                                if ($resultAuxiliar->num_rows > 0) {
                                    $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                                    $rutaArchivo = "../ComprovantesPago/Confirmados/" . $rowAuxiliar['comprovante_pago'] . ".png";
                                    CorreoComprovantePago("aceptado", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                                }
                                ?>
                                }
                                <script>
                                    alert("Pago exitoso");
                                    window.location.href = "../Vista/VerPagosAdmin.php";
                                </script> 
                                <?php
                            }
                        } else {
                            /* $sql2 = "update deudas
                              set  interes = ?
                              where id_deuda = ? ;";

                              $stmt = $conn->prepare($sql2);
                              if ($stmt === false) {
                              die("Error al preparar la consulta: " . $conn->error);
                              }
                              $stmt->bind_param("ss",$interes, $_POST['idDeuda']); */
                            $stmt = $modificador->PagoDeuda_DecrementoInteres($interes, $_POST['idDeuda']);
                            if ($stmt == true) {

                                $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($_POST['idPago']);
                                if ($resultAuxiliar->num_rows > 0) {
                                    $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
                                    $rutaArchivo = "../ComprovantesPago/Confirmados/" . $rowAuxiliar['comprovante_pago'] . ".png";
                                    CorreoComprovantePago("aceptado", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
                                }
                                ?>
                                }
                                <script>
                                    alert("Pago exitoso");
                                    window.location.href = "../Vista/VerPagosAdmin.php";
                                </script> 
                                <?php
                            }
                        }
                    }
                } else {
                    ?>
                    <script>
                        alert("Ocurrio un error");
                        window.location.href = "../Vista/VerPagosAdmin.php";
                    </script> 
                    <?php
                }
            }
        }
    }
} else if (isset($_POST['declinar'])) {

    /* $sql = "update pagos
      set estado = 2
      where id_pago = ".$_POST['idPago'].";";
      $stmt = $conn->prepare($sql);
      if ($stmt === false) {
      die("Error al preparar la consulta: " . $conn->error);
      } */
    $stmt = $modificador->RechazarPagoPorId($_POST['idPago']);
    if ($stmt == false) {
        ?>

        <script>
            alert("Ha ocurrido un error");
            window.location.href = "../Vista/VerPagosAdmin.php";
        </script> 
        <?php
    } else {


        $result = $consulta->ObtenerComprovantePorIdPago($_POST['idPago']);
        if ($result->num_rows > 0) {
            $row = $consulta->obtenerDatosDeLasConsultas($result);

            $comprovante->Comprovante_Rechazado($row['comprovante_pago']);
            //echo ("coco".$row['comprovante_pago']);
        }

        $resultAuxiliar = $consulta2->ObtenerInformacionPagoParaCorreo($_POST['idPago']);
        if ($resultAuxiliar->num_rows > 0) {
            $rowAuxiliar = $consulta2->obtenerDatosDeLasConsultas($resultAuxiliar);
            $rutaArchivo = "../ComprovantesPago/Rechazados/" . $rowAuxiliar['comprovante_pago'] . ".png";
            CorreoComprovantePago("rechazado", $rowAuxiliar['id_deuda'], $rowAuxiliar['id_pago'], $rowAuxiliar['valor_inicial'], $rowAuxiliar['valor_actual'], $rowAuxiliar['valor_pago'], $rowAuxiliar['nombre_usuario'], $rowAuxiliar['correo'], $rutaArchivo, $rowAuxiliar['interes'], $rowAuxiliar['total']);
        }
        ?>

        <script>
            alert("Pago declinado con exito");
            window.location.href = "../Vista/VerPagosAdmin.php";
        </script> 
        <?php
    }
}
?>

