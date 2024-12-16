<?php
$directorio_destino = "../Comprovantespago/Confirmados/Pago66cff4e76a94d.png";
                $directorio_origen = "../Comprovantespago/PorConfirmar/Pago66cff4e76a94d.png";

                if (rename($directorio_origen, $directorio_destino)) {
                    $imagenCargada = true;
                    $_SESSION['imagenCargada'] = true;
                    //echo "<script>alert('Imagen PNG cargada con éxito');</script>";
                    $band = true;
                }
