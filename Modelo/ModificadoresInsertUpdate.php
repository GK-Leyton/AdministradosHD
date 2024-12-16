<?php

class insertsUpdates {

    public function InsertarDeuda($monto, $interes, $idUsuario, $fecha, $credencialUsuario, $comprovante_deuda) {
        require '../ConexionBD/conexion.php';
        $sql = "INSERT INTO deudas(valor_inicial , valor_actual , porcentaje_interes , id_usuario , interes , fecha_ultimo_interes , fecha_inicial , credencial_usuario, estado , comprovante_deuda)
VALUES (?, ? , ? , ? , 0 , ? , ? , ? , 1 , ?);";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ssssssss", $monto, $monto, $interes, $idUsuario, $fecha, $fecha, $credencialUsuario, $comprovante_deuda);
        $stmt->execute();
        return $stmt;
    }

    public function PagoDeuda_DecrementoInteres($interes, $idDeuda) {
        require '../ConexionBD/conexion.php';

        /*$sql2 = "update deudas
        set  interes = ? 
        where id_deuda = ? ;";*/
        
        $sql2 = "update deudas
        SET interes = CEIL(? / 50.0) * 50 
        where id_deuda = ? ;";

        $stmt = $conn->prepare($sql2);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $interes, $idDeuda);
        $stmt->execute();
        return $stmt;
    }

    public function PagoDeuda_CierreIntereses($idDeuda, $valorActual) {
        require '../ConexionBD/conexion.php';
        /*$sql2 = "update deudas
        set valor_actual = ? , interes = 0 
        where id_deuda = ? ;";
        */
        $sql2 = "update deudas
        set valor_actual = CEIL(? / 50.0) * 50  , interes = 0 
        where id_deuda = ? ;";

        $stmt = $conn->prepare($sql2);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $valorActual, $idDeuda);
        $stmt->execute();
        return $stmt;
    }

    public function PagoDeuda_CierreDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $sql2 = "update deudas
        set estado = 0 ,  valor_actual = 0 , interes = 0 
        where id_deuda = ? ;";
        $stmt = $conn->prepare($sql2);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("s", $idDeuda);
        $stmt->execute();
        return $stmt;
    }

    public function InsertarPagos($montoPago, $idDeuda, $fecha, $estado, $comprovante_pago) {
        require '../ConexionBD/conexion.php';
        $sql = "INSERT INTO pagos(valor_pago , id_deuda, fecha_pago , estado, comprovante_pago) 
values 
( ? , ? , ? , ? , ?);";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $fecha = date('Y-m-d');
        $stmt->bind_param("sssss", $montoPago, $idDeuda, $fecha, $estado, $comprovante_pago);
        $stmt->execute();
        return $stmt;
    }

    /*  public function validarEjecutarSTMT($stmt) {
      require '../ConexionBD/conexion.php';
      $aux = $stmt->execute();
      return $aux;
      }
     */

    public function AceptarPagoPorId($idPago) {
        require '../ConexionBD/conexion.php';
        $sql = "update pagos
set estado = 0 , id_update = 1
where id_pago = " . $idPago . ";";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->execute();
        return $stmt;
    }

    public function RechazarPagoPorId($idPago) {
        require '../ConexionBD/conexion.php';
        $sql = "update pagos
set estado = 2 , id_update = 1
where id_pago = " . $idPago . ";";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->execute();
        return $stmt;
    }

    public function EditarPagoPorId($valorPago, $id_deuda, $idPago, $comprovante_pago) {
        require '../ConexionBD/conexion.php';
        $sql = "update pagos 
        set valor_pago = IFNULL(? , valor_pago) , id_deuda = IFNULL(? ,id_deuda) , comprovante_pago = ? , id_update  = ?
        where id_pago = ?;";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("sssss", $valorPago, $id_deuda, $comprovante_pago, $_SESSION['idUsuario'], $idPago);
        $stmt->execute();
        return $stmt;
    }

    public function EditarInformacionUsuarioPorId($correo, $palabra_segura, $contrasena, $id_usuario) {
        require '../ConexionBD/conexion.php';
        $sql = " UPDATE usuario
    SET correo = IFNULL(?, correo),
        palabra_segura = IFNULL(?, palabra_segura),
        contrasena = IFNULL(?, contrasena)
    WHERE id_usuario = ? ; ";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ssss", $correo, $palabra_segura, $contrasena, $id_usuario);
        $stmt->execute();
        return $stmt;
    }

    public function InsertarNuevoUsuario($nombre, $credencial, $contrasena, $palabraSegura) {
        require '../ConexionBD/conexion.php';
        $sql = "INSERT INTO usuario (nombre_usuario , credencial_usuario , contrasena , palabra_segura)
        VALUES (?,?,?,?);";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ssss", $nombre, $credencial, $contrasena, $palabraSegura);
        $stmt->execute();
        return $stmt;
    }

    public function ActualizarCedula_y_Correo_PrimeraVez($cedula, $correo, $id_usuario) {
        require '../ConexionBD/conexion.php';
        $sql = "UPDATE usuario
        set cedula = ? , correo = ?
        where id_usuario = ?;";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("sss", $cedula, $correo, $id_usuario);
        $stmt->execute();
        return $stmt;
    }

    public function ActualizarFotoPerfilPorId($idUsuario, $nombreImagen) {
        require '../ConexionBD/conexion.php';
        $sql = "UPDATE usuario
        set foto_perfil = ? 
        where id_usuario = ?;";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->bind_param("ss", $nombreImagen, $idUsuario);
        $stmt->execute();
        return $stmt;
    }

    public function ActualizarEstadoNotificaciones($idNotificacion, $estado, $tipoEstado) {
        require '../ConexionBD/conexion.php';
        $sql = "update notificaciones
set " . $tipoEstado . " = " . $estado . "
where id_notificacion = " . $idNotificacion . ";";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error al preparar la consulta: " . $conn->error);
        }
        $stmt->execute();
        return $stmt;
    }

}

?>