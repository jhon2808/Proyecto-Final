<?php

session_start();

include('db.php');

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener la información del usuario y su rol
    $consulta = "SELECT * FROM usuario WHERE usuario.idusuario = '$usuario'";

    $resultado = $conn->query($consulta);

    if ($resultado->num_rows == 1) {
            // Redirige al usuario a una página de inicio
            echo "listo";
        } else {
            echo "credenciales incorrectas";
    }
}


$conn->close();
?>
