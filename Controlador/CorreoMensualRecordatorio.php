<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../Modelo/ConsultasUsuarios.php';
require '../Controlador/Correo.php';
$consulta = new consultasUsuario();

$result = $consulta->ObtenerInformacionUsuariosConDeudasActivas_ParaEnviarCorreo();
$asunto = 'REPORTE MENSUAL - total en deudas';
if ($result->num_rows > 0) {




    while ($row = $consulta->obtenerDatosDeLasConsultas($result)) {
        $contenido = "<h2>Hola " . $row['nombre_usuario'] . ",</h2>
                    <p>En este reporte mensual deseamos avivar nuestros lazos actuales, por ello, desde AdministradosHD queremos recordarte que:<br><br><br>
                    A fecha de " . date('Y-m-d') . "<br><br>
                    Nos unen: " . $row['total_sumado'] . " deseos Colombianos<br><br>
                    Saludos,<br>AdministradosHD</p><br><br><br>";

        envioCorreo($row['correo'], $row['nombre_usuario'], $contenido, $asunto, null);
    }
    //envioCorreo("heiderleyton22@gmail.com", "Heider", $contenido, $asunto);
}
?>