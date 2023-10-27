<?php
session_start();

include ('db.php');


// Recibir datos del formulario de registro
if (isset($_POST['registro'])) {
    $rolSeleccionado = $_POST["rolSeleccionado"]; // Debe coincidir con el valor de la opción seleccionada en el formulario
    $nuevoNombre = $_POST["nuevoNombre"];
    $nuevoApellido = $_POST["nuevoApellido"];
    $nuevoCc = $_POST["nuevoCc"];
    $nuevoTelefono = $_POST["nuevoTelefono"];
    $nuevoCorreo = $_POST["nuevoCorreo"];
    $nuevaContrasena = password_hash($_POST['nuevaContrasena'], PASSWORD_DEFAULT);
    

    // Comprobar si el usuario ya existe en la base de datos
    $consultaExisteUsuario = "SELECT * FROM usuario WHERE nombre = '$nuevoNombre'";
    $resultadoExisteUsuario = $conn->query($consultaExisteUsuario);
    

    if ($resultadoExisteUsuario->num_rows > 0) {
        echo "El nombre de usuario ya está en uso.";
    } else {
        // Insertar el nuevo usuario en la tabla de usuarios
        $insercionUsuario = "INSERT INTO usuario (nombre, apellido,	cc,	telefono,	correo_electronico,	contrasena	) VALUES 
        ('$nuevoNombre','$nuevoApellido','$nuevoCc','$nuevoTelefono','$nuevoCorreo', '$nuevaContrasena')";
        $conn->query($insercionUsuario);

        if ($conn->affected_rows == 1) {
            // Obtener el ID del usuario recién insertado
            $idNuevoNombre = $conn->insert_id;

            // Insertar el rol del usuario en la tabla usuario_has_rol
            $insercionRolUsuario = "INSERT INTO rol_has_usuario (usuario_idusuario, rol_idrol) VALUES (?, ?)";
            $stmt = $conn->prepare($insercionRolUsuario);
            $stmt->bind_param("ii", $idNuevoNombre, $rolSeleccionado);

            if ($stmt->execute()) {
                header("Location: lyr.php");
                echo "Registro exitoso. Usuario agregado con rol.";
            } else {
                echo "Error al asignar el rol al usuario: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al registrar el usuario.";
        }


    }
}
$conn->close();

?>