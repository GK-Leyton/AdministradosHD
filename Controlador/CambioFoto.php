<?php
if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['PaginaAnterior'] = "../Vista/AgregarFoto.php";

require '../Modelo/ConsultasUsuarios.php';
$consulta = new consultasUsuario();
$band = true;
$result = $consulta->ObtenerFotoPerfilPorIdUsuario($_SESSION['idUsuario']);
$nombreImagenAuxiliar = "";
if ($result->num_rows > 0) {
    $row = $consulta->obtenerDatosDeLasConsultas($result);
    for ($i = 0; $i < 16; $i++) {
        //echo"<h1>fotoPerfil".($i+1)." </h1>";
        if ($row['foto_perfil'] == ("fotoPerfil" . ($i + 1))) {
            $band = false;
            $nombreImagenAuxiliar = "fotoPerfil" . uniqid("");
        }
    }
    $_SESSION['foto_perfil'] = ($nombreImagenAuxiliar != "") ? $nombreImagenAuxiliar : $row['foto_perfil'];

    /* if($band){
      echo"<h1> bandera".$band." </h1>";
      if(file_exists("../FotosPerfil/Confirmadas/".$_SESSION['foto_perfil'].".png")){
      if(unlink("../FotosPerfil/Confirmadas/".$_SESSION['foto_perfil'].".png")){
      }else{
      //echo"<h1>Se borró</h1>";
      }
      }else{
      //echo"<h1>no existe</h1>";
      }

      } */
    ?><script>
        window.location.href = "../Vista/AgregarFoto.php";
    </script><?php
}



