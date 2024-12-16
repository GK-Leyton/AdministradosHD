<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('America/Bogota');
require '../Controlador/Correo.php';

CorreoComprovanteDeuda();

function CorreoComprovanteDeuda() {

    $asunto = 'respaldo' . date('Y-m-d');

    $contenido = "<h2>Hola Admin,</h2>
                    <p>Este es un reporte de respaldo de tu BASE DE DATOS:<br><br><br>
                    Se hace respaldo a fecha de " . date('Y-m-d') . "<br><br><br>                    
                    Saludos,<br>AdministradosHD</p><br><br><br>";
    $archivo = "../../Respaldos/RespaldosBD/Respaldo-" . date('Y-m-d') . ".sql";
    envioCorreo("respaldosadmdeudas@gmail.com", "Heider", $contenido, "$asunto", $archivo);
}

?>