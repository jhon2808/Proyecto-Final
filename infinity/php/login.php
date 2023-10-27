<?php

session_start();

include('db.php');

if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Consulta para obtener la información del usuario y su rol
    $consulta = "SELECT usuario.idusuario, usuario.correo_electronico, usuario.telefono, usuario.nombre, usuario.contrasena, rol.nombre_rol
    FROM usuario 
    INNER JOIN rol_has_usuario ON usuario.idusuario = rol_has_usuario.usuario_idusuario
    INNER JOIN rol ON rol_has_usuario.rol_idrol = rol.idrol
    WHERE usuario.correo_electronico = '$usuario'";

    $resultado = $conn->query($consulta);

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        $contrasena_encriptada = $fila["contrasena"];

        // Verificar la contraseña encriptada
        if (password_verify($contrasena, $contrasena_encriptada)) {
            // Contraseña válida, almacenar información del usuario en la sesión
            $_SESSION["id_usuario"] = $fila["idusuario"];
            $_SESSION["nombre_usuario"] = $fila["nombre"];
            $_SESSION["apellido"] = $fila["apellido"];
            $_SESSION["correo"] = $fila["correo_electronico"];
            $_SESSION["rol_usuario"] = $fila["nombre_rol"];
            $_SESSION["telefono"] = $fila["telefono"];
            $_SESSION["contrasena"] = $fila["contrasena"];
            // Redirige al usuario a una página de inicio
            header("Location: ../php/inicio.php");
        } else {
            echo "Contraseña Incorrecta";
        }
    } else {
        echo "no existe un usuario con ese correo";

    }
}

$conn->close();
?>
