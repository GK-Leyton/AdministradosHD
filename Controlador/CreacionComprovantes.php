<?php

class Comprovante {

    public function ComprovanteNoConfirmado($id_pago, $montoPago, $idDeuda, $fecha, $nombreComprovante, $tipo) {
        $ancho = 500;
        $alto = 600;

        // Crear una imagen en blanco
        $imagen = imagecreatetruecolor($ancho, $alto);
        $blanco = imagecolorallocate($imagen, 255, 255, 255);
        $negro = imagecolorallocate($imagen, 0, 0, 0);
        imagefilledrectangle($imagen, 0, 0, $ancho, $alto, $negro);

        $x_proporcional = $ancho * 0.005;
        $y_proporcional = $alto * 0.005;
        $cuadro_ancho = $ancho * 0.99;
        $cuadro_alto = $alto * 0.99;

        imagefilledrectangle($imagen, $x_proporcional, $y_proporcional, $x_proporcional + $cuadro_ancho, $y_proporcional + $cuadro_alto, $blanco);

        // Llamar a los métodos utilizando $this
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, 0, 5, ($tipo) ? "Comprovante del pago " . $id_pago : "Comprovante de Deuda " . $id_pago), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, -250), ($tipo) ? "Comprovante del pago " . $id_pago : "Comprovante de Deuda " . $id_pago, $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, ($tipo) ? "Id del pago: " . $id_pago : "Id de la Deuda: " . $id_pago), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, -200), ($tipo) ? "Id del pago: " . $id_pago : "Id de la Deuda: " . $id_pago, $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, ($tipo) ? "Monto del pago: " . $montoPago : "Monto de la deuda: " . $montoPago), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, -150), ($tipo) ? "Monto del pago: " . $montoPago : "Monto de la deuda: " . $montoPago, $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, ($tipo) ? "Id deuda: " . $idDeuda : "Credencial Usuario: " . $idDeuda), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, -100), ($tipo) ? "Id deuda: " . $idDeuda : "Credencial Usuario: " . $idDeuda, $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, "Fecha: " . $fecha), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, -50), "Fecha: " . $fecha, $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, "Firma Administrador: "), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, 150), "Firma Administrador: ", $negro);
        imagestring($imagen, 5, $this->ejexDesdeElCentro($x_proporcional, $cuadro_ancho, -200, 5, "-----------------------------"), $this->ejeyDesdeElCentro($y_proporcional, $cuadro_alto, 5, 240), "-----------------------------", $negro);

        if ($tipo) {
            $ruta_guardado = '../ComprovantesPago/PorConfirmar/' . $nombreComprovante . ".png";
        } else {
            $ruta_guardado = '../ComprovantesDeuda/PorConfirmar/' . $nombreComprovante . ".png";
        }


        if (imagepng($imagen, $ruta_guardado)) {
            //echo "Imagen guardada con éxito en $ruta_guardado";
        } else {
            //echo "Error al guardar la imagen.";
        }
        imagedestroy($imagen);
    }

    public function ejexDesdeElCentro($x_proporcional, $cuadro_ancho, $movimiento, $font_size, $text) {
        $text_ancho = imagefontwidth($font_size) * strlen($text);
        if ($movimiento != 0) {
            $text_ancho = 0;
        }
        return $x_proporcional + ($cuadro_ancho / 2) - ($text_ancho / 2) + $movimiento;
    }

    public function ejeyDesdeElCentro($y_proporcional, $cuadro_alto, $font_size, $movimiento) {
        $text_alto = imagefontheight($font_size);
        return ($y_proporcional + ($cuadro_alto / 2) - ($text_alto / 2)) + $movimiento;
    }

    public function aprovarComprovante($nombreComprovante, $tipo) {
        // Definir rutas de los archivos
        $ruta_comprovante_por_confirmar = "";
        $ruta_comprovante_confirmado = "";

        if ($tipo) {
            $ruta_comprovante_por_confirmar = "../ComprovantesPago/PorConfirmar/{$nombreComprovante}.png";
            $ruta_comprovante_confirmado = "../ComprovantesPago/Confirmados/{$nombreComprovante}.png";
        } else {
            $ruta_comprovante_por_confirmar = "../ComprovantesDeuda/PorConfirmar/{$nombreComprovante}.png";
            $ruta_comprovante_confirmado = "../ComprovantesDeuda/Aprovados/{$nombreComprovante}.png";
        }
        // Verificar si la imagen por confirmar existe
        if (!file_exists($ruta_comprovante_por_confirmar)) {
            //echo "Error: No se pudo encontrar la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Crear la imagen desde el archivo por confirmar
        $imagen = imagecreatefrompng($ruta_comprovante_por_confirmar);
        if ($imagen === false) {
            //echo "Error: No se pudo abrir la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Cargar imágenes adicionales (sello, firma)
        $sello = imagecreatefrompng('../imagenes/CredencialesAdministradosHD/sello.png');
        $firma = imagecreatefrompng('../imagenes/CredencialesAdministradosHD/firma.png');
        $rojo = imagecolorallocate($imagen, 255, 0, 0);

        // Agregar elementos a la imagen principal
        imagecopy($imagen, $sello, 350, 450, 0, 0, 100, 100);
        imagecopy($imagen, $firma, 40, 485, 0, 0, 276, 51);
        imagestring($imagen, 5, 368, 440, "Aprobado", $rojo);

        // Guardar la imagen modificada en la carpeta de Confirmados
        if (imagepng($imagen, $ruta_comprovante_confirmado)) {
            //echo "Imagen guardada con éxito en $ruta_comprovante_confirmado";
            // Eliminar la imagen por confirmar en la carpeta de NoConfirmados
            if (unlink($ruta_comprovante_por_confirmar)) {
                //echo "Imagen eliminada con éxito de $ruta_comprovante_por_confirmar";
            } else {
                //echo "Error al eliminar la imagen de $ruta_comprovante_por_confirmar";
            }
        } else {
            //echo "Error al guardar la imagen en $ruta_comprovante_confirmado";
        }

        // Liberar memoria
        imagedestroy($imagen);
        imagedestroy($sello);
        imagedestroy($firma);

        //echo 'Texto agregado correctamente a la imagen existente.';
    }

    public function Comprovante_Rechazado($nombreComprovante) {
        // Definir rutas de los archivos
        $ruta_comprovante_por_confirmar = "../ComprovantesPago/PorConfirmar/{$nombreComprovante}.png";
        $ruta_comprovante_rechazado = "../ComprovantesPago/Rechazados/{$nombreComprovante}.png";

        // Verificar si la imagen por confirmar existe
        if (!file_exists($ruta_comprovante_por_confirmar)) {
            //echo "Error: No se pudo encontrar la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Crear la imagen desde el archivo por confirmar
        $imagen = imagecreatefrompng($ruta_comprovante_por_confirmar);
        if ($imagen === false) {
            //echo "Error: No se pudo abrir la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Agregar texto "DENEGADO"
        $sello = imagecreatefrompng('../imagenes/CredencialesAdministradosHD/sello.png');
        $firma = imagecreatefrompng('../imagenes/CredencialesAdministradosHD/firma.png');
        $rojo = imagecolorallocate($imagen, 255, 0, 0);

        // Agregar elementos a la imagen principal
        imagecopy($imagen, $sello, 350, 450, 0, 0, 100, 100);
        imagecopy($imagen, $firma, 40, 485, 0, 0, 276, 55);
        imagestring($imagen, 5, 368, 440, "Denegado", $rojo);

        // Guardar la imagen modificada en la carpeta de Rechazados
        if (imagepng($imagen, $ruta_comprovante_rechazado)) {
            //echo "Imagen rechazada y guardada correctamente en $ruta_comprovante_rechazado";
            // Eliminar la imagen por confirmar en la carpeta de PorConfirmar
            if (unlink($ruta_comprovante_por_confirmar)) {
                //echo "Imagen original eliminada con éxito de $ruta_comprovante_por_confirmar";
            } else {
                //echo "Error al eliminar la imagen original de $ruta_comprovante_por_confirmar";
            }
        } else {
            //echo "Error al guardar la imagen rechazada en $ruta_comprovante_rechazado";
        }

        // Liberar memoria
        imagedestroy($imagen);
        imagedestroy($sello);
        imagedestroy($firma);

        //echo 'Texto agregado correctamente a la imagen existente.';
    }

    public function FinalizarDeudaComprovante($nombreComprovante) {



        $ruta_comprovante_por_confirmar = "../ComprovantesDeuda/Aprovados/{$nombreComprovante}.png";
        $ruta_comprovante_confirmado = "../ComprovantesDeuda/Aprovados/{$nombreComprovante}.png";

        // Verificar si la imagen por confirmar existe
        if (!file_exists($ruta_comprovante_por_confirmar)) {
            //echo "Error: No se pudo encontrar la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Crear la imagen desde el archivo por confirmar
        $imagen = imagecreatefrompng($ruta_comprovante_por_confirmar);
        if ($imagen === false) {
            //echo "Error: No se pudo abrir la imagen en $ruta_comprovante_por_confirmar";
            return;
        }

        // Cargar imágenes adicionales (sello, firma)

        $rojo = imagecolorallocate($imagen, 255, 0, 0);

        // Agregar elementos a la imagen principal

        imagestring($imagen, 5, 358, 420, "Finalizada", $rojo);

        // Guardar la imagen modificada en la carpeta de Confirmados
        if (imagepng($imagen, $ruta_comprovante_confirmado)) {
            //echo "Imagen guardada con éxito en $ruta_comprovante_confirmado";        
        } else {
            //echo "Error al guardar la imagen en $ruta_comprovante_confirmado";
        }

        // Liberar memoria
        imagedestroy($imagen);

        //echo 'Texto agregado correctamente a la imagen existente.';
    }

}

?>
