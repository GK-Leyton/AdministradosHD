<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function envioCorreo($correo, $nombre, $contenido, $asunto, $rutasArchivos) {


    require '../vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP de Gmail
        $mail->SMTPAuth = true;
        $mail->Username = 'admdeudas@gmail.com'; // Tu correo de Gmail
        $mail->Password = 'wqaufyzkbapjjkdy'; // Tu contraseña de Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('admdeudas@gmail.com', 'AdministradosHD');
        $mail->addAddress($correo, $nombre);

        // Adjuntar la imagen
        $mail->addEmbeddedImage('../imagenes/CredencialesAdministradosHD/Logo.png', 'logo_image'); // 'logo_image' es el CID
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $asunto;
        $mail->Body = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    width: 80%;
                    margin: auto;
                    overflow: hidden;
                }
                .header {
                    background: #333;
                    color: #fff;
                    padding: 10px 0;
                    text-align: center;
                }
                .logo-container {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .main {
                    padding: 20px;
                    background: #fff;
                    border: 1px solid #ddd;
                    margin-bottom: 60px; /* Espacio suficiente para el footer */
                }
                .footer {
                    background: #333;
                    color: #fff;
                    text-align: center;
                    padding: 10px 0;
                    position: relative;
                    bottom: 0;
                    width: 100%;
                }
                p {
                    text-align: justify;
                }
                
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Administrados HD</h1>
                </div>
                <div class="logo-container">
                    <!-- Logo -->
                    <img src="cid:logo_image" alt="Logo" width="150">
                </div>
                <div class="main">                    
                ' . $contenido . '
<p style="text-align: center;" >&copy; Para mas informacion visita nuestra pagina web.</p>                
</div>
                <div class="footer">
                    <p style="text-align: center;" >&copy; ' . date("Y") . ' AdministradosHD. Todos los derechos reservados.</p>
                    
                </div>
            </div>
        </body>
        </html>
    ';

        if ($rutasArchivos != null) {
            if (is_array($rutasArchivos)) {
                foreach ($rutasArchivos as $rutas) {
                    $mail->addAttachment($rutas);
                }
            } else if (is_string($rutasArchivos)) {
                $mail->addAttachment($rutasArchivos);
            } else {
                throw new InvalidArgumentException("La variable \$rutasArchivos debe ser una cadena o un array.");
            }
        }



        $data = [
            "CORREO:    " . $correo . "   -   \n",
            "NOMBRE: " . $nombre . "   -   \n",
            "CONTENIDO:    " . $contenido . "   -   \n",
            "ASUNTO:    " . $asunto . "   -   \n",
            "RUTA_ARCHIVO:    " . $rutasArchivos . "   -   \n",
            "FECHA_Y_HORA:    " . date('Y-m-d H:i:s'),
            "\n", "\n",
            "-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-",
            "\n", "\n"
        ];
        $filename = '../HistorialCorreos/LogCorreos.txt';
        $file = fopen($filename, 'a');
        if ($file) {
            foreach ($data as $row) {
                fwrite($file, $row);
            }
            fclose($file);
        } else {
            echo "No se pudo abrir el archivo.";
        }

        $mail->send();
        echo 'Correo enviado exitosamente.';
    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
