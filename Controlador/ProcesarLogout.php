<?php
// Iniciar sesión si no está iniciada
session_start();

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redireccionar al usuario al login
//header("Location: ../Vista/login.php");
?><script>
    window.location.href = "../Vista/login.php";
</script><?php
exit;
?>