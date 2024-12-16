<?php

class consultasUsuario {

    public function obtenerUsuarioPorCredencial($usuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT * FROM usuario WHERE credencial_usuario = '$usuario'";
        $result = $conn->query($sql);
        return $result;
    }

    public function obtenerUsuarioPorTipo($tipo) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select * from usuario where tipo = " . $tipo . ";");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function obtenerDatosDeLasConsultas($result) {
        require '../ConexionBD/conexion.php';
        return $result->fetch_assoc();
    }

    public function ObtenerDeudasPorIdUario_y_Estado($idUsuario, $estado) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select * from deudas where id_usuario = ? AND estado = ?;");
        $stmt->bind_param("ss", $idUsuario, $estado);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerTotalPagadoPorIdDeuda_y_estado($idDeuda, $estado) {
        require '../ConexionBD/conexion.php';
        $stmt2 = $conn->prepare("select  SUM(valor_pago) total_pagado from pagos
WHERE id_deuda = ? and estado = ?
GROUP BY id_deuda;
");
        $stmt2->bind_param("ss", $idDeuda, $estado);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }

    public function obtenerTotalDeudaPorIdDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $stmt3 = $conn->prepare("select (valor_actual + interes) as TOTAL from deudas
WHERE id_deuda = ?;");
        $stmt3->bind_param("s", $idDeuda);
        $stmt3->execute();
        $result3 = $stmt3->get_result();
        return $result3;
    }

    public function ObtenerValorSumadoDeudasPorIdUsuario_y_EstadoActivo($idUsuario) {
        require '../ConexionBD/conexion.php';
        $stmt2 = $conn->prepare("SELECT SUM(TOTAL) AS total_sumado
FROM (
    SELECT (valor_actual + interes) AS TOTAL 
    FROM deudas
    WHERE id_usuario = ? AND estado = 1
) AS subconsulta;
");
        $stmt2->bind_param("s", $idUsuario);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }

    public function ObtenerValorSumadoDeudasPorCredencialUsuario_y_EstadoActivo($auxiliarSimbolo, $credencialUsuario) {
        require '../ConexionBD/conexion.php';
        $consulta = "SELECT SUM(TOTAL) AS total_sumado FROM (SELECT (valor_actual + interes) AS TOTAL FROM deudas WHERE estado = 1 and credencial_usuario " . $auxiliarSimbolo . " '" . $credencialUsuario . "') AS subconsulta;";
        $stmt2 = $conn->prepare($consulta);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }
    
    public function ObtenerGananaciasDelDia() {
        require '../ConexionBD/conexion.php';
        $consulta = "SELECT ganancia_diferencia
FROM ganancias
WHERE id_ganancia = (SELECT MAX(id_ganancia) FROM ganancias);";
        $stmt2 = $conn->prepare($consulta);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }

    public function ObtenerValorSumadoDeudasPorIdUsuario_y_EstadoInactivo($idUsuario) {
        require '../ConexionBD/conexion.php';
        $stmt2 = $conn->prepare("SELECT SUM(TOTAL) AS total_sumado
FROM (
    SELECT SUM(valor_pago) AS TOTAL 
    FROM pagos inner join deudas 
    on pagos.id_deuda = deudas.id_deuda inner join usuario
	on deudas.id_usuario = usuario.id_usuario
    WHERE usuario.id_usuario = ? AND deudas.estado = 0 AND pagos.estado = 0
) AS subconsulta;
");
        $stmt2->bind_param("s", $idUsuario);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }

    public function ObtenerValorSumadoDeudasPorEstado($estadoDeuda, $estadoPagos) {
        require '../ConexionBD/conexion.php';
        $stmt2 = $conn->prepare("SELECT SUM(TOTAL) AS total_sumado
FROM (
    SELECT SUM(valor_pago) AS TOTAL 
    FROM pagos inner join deudas 
    on pagos.id_deuda = deudas.id_deuda inner join usuario
	on deudas.id_usuario = usuario.id_usuario
    WHERE deudas.estado = ? AND pagos.estado = ?
) AS subconsulta;
");
        $stmt2->bind_param("ss", $estadoDeuda, $estadoPagos);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        return $result2;
    }

    public function ObtenerPagosPorIdDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select * from pagos where id_deuda = ?;");
        $stmt->bind_param("s", $idDeuda);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerXIntormacionDeudasPorEstado_y_Idusuario($estado, $idUsurio) {
        require '../ConexionBD/conexion.php';
        $stmt0 = $conn->prepare("select DISTINCT deudas.valor_inicial , deudas.id_deuda , deudas.valor_actual from pagos INNER JOIN deudas
on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
where pagos.estado = " . $estado . " AND usuario.id_usuario = " . $idUsurio . "
GROUP BY deudas.id_deuda;");
        $stmt0->execute();
        $result0 = $stmt0->get_result();
        return $result0;
    }

    public function ObtenerXIntormacionClientePorEstado($estado) {
        require '../ConexionBD/conexion.php';
        $stmt0 = $conn->prepare("select DISTINCT nombre_usuario , usuario.id_usuario from pagos INNER JOIN deudas
on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
where pagos.estado = " . $estado . "
GROUP BY nombre_usuario;");
        $stmt0->execute();
        $result0 = $stmt0->get_result();
        return $result0;
    }

    public function ObtenerXIntormacionClientePorEstado_Complemento($estado, $auxiliarSimbolo, $auxiliarConsulta) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select pagos.* , usuario.nombre_usuario , usuario.id_usuario from pagos INNER JOIN deudas
on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
where pagos.estado " . $auxiliarSimbolo . " ?  " . $auxiliarConsulta . " ");
        $stmt->bind_param("s", $estado);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerInformacionPagosClientePorEstadoPago_IdUsuario($auxiliarSimbolo, $estado, $idUsuario, $auxiliarConsulta) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select pagos.* , usuario.nombre_usuario , usuario.id_usuario from pagos INNER JOIN deudas
on pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
where pagos.estado " . $auxiliarSimbolo . " " . $estado . "  and usuario.id_usuario = " . $idUsuario . " " . $auxiliarConsulta);

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerValorActual_y_TotalPagar_PorIdDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select valor_actual as total_pagar , (valor_actual + interes) as total_pagar2 from deudas where id_deuda = " . $idDeuda . " ;");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerInteresPorIdDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select interes from deudas where id_deuda = " . $idDeuda . " ;");
        $stmt->execute();
        $result2 = $stmt->get_result();
        return $result2;
    }

    public function ObtenerCredencialUsuarioPorEstadoDeudaActiva() {
        require '../ConexionBD/conexion.php';
        $stmt0 = $conn->prepare("select DISTINCT  credencial_usuario from deudas where estado = 1 GROUP BY credencial_usuario;");
        $stmt0->execute();
        $result0 = $stmt0->get_result();
        return $result0;
    }

    public function ObtenerDeudasActivasPorCredencialUsuario($auxiliarSimbolo, $credencialUsuario) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select * from deudas where estado = 1 and credencial_usuario " . $auxiliarSimbolo . " '" . $credencialUsuario . "';");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerDeudasPorEstado($estado) {
        require '../ConexionBD/conexion.php';
        $stmt = $conn->prepare("select * from deudas where estado = " . $estado . ";");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function ObtenerValorPago_IdDeuda_PorIdPago($idPago) {
        require '../ConexionBD/conexion.php';
        $stmt0 = $conn->prepare("SELECT pagos.valor_pago , pagos.id_deuda , sum(deudas.valor_actual + deudas.interes) as total_pagar  FROM pagos 
INNER JOIN deudas 
on pagos.id_deuda = deudas.id_deuda
        WHERE id_pago = " . $idPago . ";");
        $stmt0->execute();
        $result0 = $stmt0->get_result();
        return $result0;
    }

    public function ObtenerIdDeudasActivas_y_Totalpagar_PorIdUsuario($idUsuario) {
        require '../ConexionBD/conexion.php';
        $stmt1 = $conn->prepare("SELECT  deudas.id_deuda , (valor_actual + interes) as total_pagar FROM deudas
        WHERE deudas.id_usuario = " . $idUsuario . " AND deudas.estado = 1;");
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        return $result1;
    }

    public function ObtenerCredencialesUsuarioPorDocumento($documento) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT palabra_segura , nombre_usuario , id_usuario FROM usuario WHERE cedula = " . $documento . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ValidarCredencialUsuarioExistentePorCredencialUsuario($credencialUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT credencial_usuario FROM usuario WHERE credencial_usuario = '" . $credencialUsuario . "';";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerIdPagoPorComprovante($comprovante) {
        require '../ConexionBD/conexion.php';
        $sql = "select id_pago from pagos
        where comprovante_pago = '" . $comprovante . "';";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerComprovantePorIdPago($idPago) {
        require '../ConexionBD/conexion.php';
        $sql = "select COALESCE(comprovante_pago , 'sin_comprovante') as comprovante_pago from pagos
        where id_pago = " . $idPago . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerIdDeudaPorComprovante($comprovante) {
        require '../ConexionBD/conexion.php';
        $sql = "select id_deuda from deudas
        where comprovante_deuda = '" . $comprovante . "';";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionPagoPorId($idPago) {
        require '../ConexionBD/conexion.php';
        $sql = "select * from pagos
        where id_pago = " . $idPago . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerComprovantePorIdDeuda($idDeuda) {
        require '../ConexionBD/conexion.php';
        $sql = "select comprovante_deuda from deudas
        where id_deuda = " . $idDeuda . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerFotoPerfilPorIdUsuario($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT foto_perfil
from usuario where id_usuario = " . $idUsuario . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInfoUsuarioPorId($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT *
from usuario where id_usuario = " . $idUsuario . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionUsuariosConDeudasActivas_ParaEnviarCorreo() {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT SUM(TOTAL) AS total_sumado , nombre_usuario , correo
FROM (SELECT (valor_actual + interes) AS TOTAL , usuario.nombre_usuario , usuario.correo
      FROM deudas inner join usuario
      on deudas.id_usuario = usuario.id_usuario
      WHERE deudas.estado = 1) AS subconsulta
      GROUP BY nombre_usuario;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ConocerCantidadDeudasSinInteres($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT count(*) as cantidad 
FROM deudas
where porcentaje_interes = 0 AND estado = 1 AND id_usuario = " . $idUsuario . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionDeudaParaCorreo($idDeuda) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT id_deuda , valor_inicial , valor_actual , usuario.nombre_usuario , usuario.correo FROM
deudas INNER JOIN usuario
ON deudas.id_usuario = usuario.id_usuario
where id_deuda =  " . $idDeuda . " ;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionPagoParaCorreo($idPago) {
        require '../ConexionBD/conexion.php';
        $sql = "select (deudas.valor_actual + interes) as total , interes , deudas.id_deuda , pagos.id_pago , deudas.valor_inicial , deudas.valor_actual , pagos.valor_pago , usuario.nombre_usuario , usuario.correo , pagos.comprovante_pago  from pagos INNER join deudas on pagos.id_deuda = deudas.id_deuda INNER join usuario on deudas.id_usuario = usuario.id_usuario where pagos.id_pago = " . $idPago . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerNotificacionesUsuario($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT notificaciones.fecha , notificaciones.id_notificacion , notificaciones.id_externo , notificaciones.estado FROM notificaciones INNER JOIN deudas
ON notificaciones.id_externo = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.tipo = 0 AND usuario.id_usuario = " . $idUsuario . " 
AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
ORDER BY notificaciones.fecha DESC
LIMIT 10;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerCantidadNotificacionesActivasUsuario($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT (cantidadPagos.cantidad + cantidadIntereses.cantidad) as cantidad
FROM (
    SELECT COUNT(*) AS cantidad
    FROM notificaciones
    INNER JOIN deudas ON notificaciones.id_externo = deudas.id_deuda
    INNER JOIN usuario ON deudas.id_usuario = usuario.id_usuario
    WHERE notificaciones.estado = 1
	AND notificaciones.tipo = 0
    AND usuario.id_usuario = " . $idUsuario . "
    AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
) AS cantidadIntereses,
(
	SELECT COUNT(*) AS cantidad FROM notificaciones  INNER JOIN pagos
	ON notificaciones.id_externo = pagos.id_pago INNER JOIN deudas
	ON pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
	ON deudas.id_usuario = usuario.id_usuario
	WHERE notificaciones.estado = 1 AND notificaciones.tipo = 1 AND usuario.id_usuario  = " . $idUsuario . "
	AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND pagos.id_update IS NOT NULL    
) AS cantidadPagos;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerCantidadNotificacionesActivasAdministrador() {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT (cantidadIntereses.cantidad + cantidadDeudas.cantidad) AS cantidad
FROM (
    SELECT COUNT(*) AS cantidad
    FROM notificaciones
    INNER JOIN deudas ON notificaciones.id_externo = deudas.id_deuda
    INNER JOIN usuario ON deudas.id_usuario = usuario.id_usuario
    WHERE notificaciones.estado2 = 1
    AND usuario.id_usuario > 0
    AND notificaciones.tipo = 0
    AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
) AS cantidadIntereses,
(
    SELECT COUNT(*) AS cantidad
    FROM notificaciones
    INNER JOIN pagos ON notificaciones.id_externo = pagos.id_pago
    INNER JOIN deudas ON pagos.id_deuda = deudas.id_deuda
    INNER JOIN usuario ON deudas.id_usuario = usuario.id_usuario
    WHERE notificaciones.tipo = 1
    AND usuario.id_usuario > 0
    AND notificaciones.estado2 = 1
    AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY)
) AS cantidadDeudas;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionDeuda_Por_Notificaciones($id_notificacion) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT  deudas.porcentaje_interes ,deudas.id_deuda , deudas.valor_inicial , deudas.valor_actual , (deudas.valor_actual + deudas.interes) as total , deudas.fecha_ultimo_interes , deudas.interes  FROM  notificaciones INNER JOIN deudas
ON notificaciones.id_externo = deudas.id_deuda
INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.id_notificacion = " . $id_notificacion . " AND notificaciones.tipo = 0;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerInformacionPago_Por_Notificaciones($id_notificacion) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT  pagos.id_pago , pagos.id_deuda , pagos.valor_pago , pagos.fecha_pago , pagos.comprovante_pago , pagos.estado
FROM  notificaciones INNER JOIN pagos
ON notificaciones.id_externo = pagos.id_pago
WHERE notificaciones.id_notificacion = " . $id_notificacion . " AND notificaciones.tipo = 1;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerFotoPerfil_ComprovanteDeuda_PorNotificacion($id_notificacion) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT usuario.foto_perfil , deudas.comprovante_deuda FROM notificaciones INNER JOIN deudas
on notificaciones.id_externo = deudas.id_deuda
INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.id_notificacion = " . $id_notificacion . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerFotoPerfil_ComprovantePago_PorNotificacion($id_notificacion) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT usuario.foto_perfil , pagos.comprovante_pago FROM notificaciones INNER JOIN pagos
on notificaciones.id_externo = pagos.id_pago
INNER JOIN deudas
ON pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.id_notificacion = " . $id_notificacion . ";";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerComprovanteDeudaPorIdDeuda($id_deuda) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT deudas.comprovante_deuda from deudas
where deudas.id_deuda = " . $id_deuda . " ;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerNotificacionesIntereses_ParaElAdmin() {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT notificaciones.fecha , notificaciones.id_notificacion , notificaciones.id_externo , notificaciones.estado2 FROM notificaciones INNER JOIN deudas
ON notificaciones.id_externo = deudas.id_deuda INNER JOIN usuario
on deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.tipo = 0 AND usuario.id_usuario > 0 
AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
ORDER BY notificaciones.fecha DESC , notificaciones.estado2 desc;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerNotificacionesPagos_ParaElAdmin() {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT deudas.id_deuda , notificaciones.fecha , notificaciones.id_notificacion , notificaciones.id_externo , notificaciones.estado2 FROM notificaciones INNER JOIN pagos
ON notificaciones.id_externo = pagos.id_pago INNER JOIN deudas
ON pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
ON deudas.id_usuario = usuario.id_usuario
WHERE notificaciones.tipo = 1 AND usuario.id_usuario > 0 
AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
ORDER BY notificaciones.fecha DESC , notificaciones.estado2 asc;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerNotificacionesPagos_ParaElCliente($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "SELECT deudas.id_deuda , notificaciones.fecha , notificaciones.id_notificacion , notificaciones.id_externo , notificaciones.estado , pagos.id_update FROM notificaciones  INNER JOIN pagos
ON notificaciones.id_externo = pagos.id_pago INNER JOIN deudas
ON pagos.id_deuda = deudas.id_deuda INNER JOIN usuario
ON deudas.id_usuario = usuario.id_usuario
WHERE  notificaciones.tipo = 1 AND usuario.id_usuario  = " . $idUsuario . "
AND notificaciones.fecha > DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND pagos.id_update IS NOT NULL
ORDER BY notificaciones.estado asc
LIMIT 10 ;";
        $result = $conn->query($sql);
        return $result;
    }

    public function ObtenerTipoUsuarioPorId($idUsuario) {
        require '../ConexionBD/conexion.php';
        $sql = "Select tipo from usuario where id_usuario = " . $idUsuario . ";";
        $result = $conn->query($sql);
        return $result;
    }

}

?>