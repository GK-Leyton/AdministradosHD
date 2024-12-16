<?php

if (isset($_POST['cargarImagen'])) {
    ?>
    <script>
        alert("Se te pedira tomar o subir una imagen para tu perfil");
        window.location.href = "../Vista/TerminarAgregarFoto.php";
    </script>
    <?php

} else if (isset($_POST['noCargarImangen'])) {
    ?>
    <script>
        alert("Se te darán multiples opcciones para usar como imagen de perfil");
        window.location.href = "../Vista/TerminarAgregarFoto_Predeterminadas.php";
    </script>
    <?php

}
