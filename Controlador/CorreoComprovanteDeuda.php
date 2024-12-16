<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Controlador/Correo.php';

function CorreoComprovanteDeuda($idDeuda, $valor_inicial, $valor_actual, $nombre_usuario, $correo, $archivo) {

    $asunto = 'REPORTE DEUDA - nueva deuda';

    $contenido = "<h2>Hola " . $nombre_usuario . ",</h2>
                    <p>En este reporte deseamos hablarte sobre tu nueva deuda, por ello, desde AdministradosHD queremos compartirte que:<br><br><br>
                    A fecha de " . date('Y-m-d') . " Se ha registrado una nueva deuda.<br><br><br>
                    Con ID: " . $idDeuda . "<br><br>
                    Con un valor inicial: " . $valor_inicial . "<br><br>
                    Con un valor actual: " . $valor_actual . "<br><br>
                    Saludos,<br>AdministradosHD</p><br><br><br>";

    envioCorreo($correo, $nombre_usuario, $contenido, $asunto, $archivo);
}

?>