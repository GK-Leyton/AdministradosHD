<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Controlador/Correo.php';

function CorreoComprovantePago($modo, $idDeuda, $idPago, $valor_inicial, $valor_actual, $valorPago, $nombre_usuario, $correo, $archivo, $interes, $total) {

    $asunto = 'REPORTE DEUDA - nueva pago';
    $modo_aux = "";

    if ($modo == 'aceptado') {
        $modo_aux = 'Tu pago ha sido aceptado por el area de validaciones<br><br><br>';
    } else if ($modo == 'rechazado') {
        $modo_aux = 'Tu pago ha sido rechazado por el area de validaciones<br><br><br>';
    } else if ($modo == 'terminado') {
        $modo_aux = 'Se ha registrado un nuevo pago y ha finiquitado una deuda<br><br><br>';
    } else if ($modo == 'terminado_aceptado') {
        $modo_aux = 'Tu pago ha sido aceptado y ha finiquitado una deuda<br><br><br>';
    } else if ($modo == 'Pago_Cliente') {
        $modo_aux = 'El pago que acabas de registrar ha ido al area de validaciones<br><br><br>';
    }else if ($modo == 'Pago_Cliente_paraAdmin') {
        $modo_aux = 'Acaban de realizar un pago, VE A COMPROVARLO ADMIN!!!<br><br><br>';
    } else {
        $modo_aux = 'Se ha registrado un nuevo pago<br><br><br>';
    }
    $contenido = "<h2>Hola " . $nombre_usuario . ",</h2>
<p>En este reporte deseamos hablarte sobre tu nuevo pago, por ello, desde AdministradosHD queremos compartirte que:<br><br><br>                    
A fecha de " . date('Y-m-d') . " " . $modo_aux . " 
Con ID pago: " . $idPago . "<br><br>
Con ID deuda: " . $idDeuda . "<br><br>
Con un valor pago: " . $valorPago . "<br><br>
Con un valor inicial (deuda): " . $valor_inicial . "<br><br>
Con un valor actual (deuda): " . $valor_actual . "<br><br>
Con un interes total (deuda): " . $interes . "<br><br>
Con un valor total (deuda): " . $total . "<br><br>
Saludos, <br>AdministradosHD</p><br><br><br>";

    envioCorreo($correo, $nombre_usuario, $contenido, $asunto, $archivo);
}

?>