<?php
session_start();
if (!isset($_SESSION["nombre_usuario"])) {
  header("Location: ../html/index.html");
  exit();
}

$nombreUsuario = $_SESSION['nombre_usuario'];

// Establecer conexión con la base de datos (reemplaza con tus credenciales)
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
        header("El nombre de usuario ya está en uso.");
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
                header("Location: ../php/inicio.php");
                echo "Registro exitoso. Usuario agregado con rol.";
            } else {
                echo "Error al asignar el rol al usuario: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error al registrar el usuario.";
        }

        // ... Tu código posterior ...

    }
}
$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/reg.css">

</head>
<body>
    <div class="pos">
    <div class="f">
    <h2>Registro de Usuario</h2>
    <form method="post" action="">
    <div class="xaxa">
        <label for="rolSeleccionado">Rol:</label><br><br>
        <select name="rolSeleccionado" id="rolSeleccionado" required>
        <option id="op" value="1">Admin</option>
        <option id="op" value="2">Operador</option>
        </select><br><br><br>
    </div>
      <div class="input-container">
      <div class="input-effect">
        <input type="text" id="nuevoNombre" name="nuevoNombre" required>
        <label for="nuevoNombre">Nombre:</label>
      </div><br><br>
      </div>
      <div class="input-container">
        <div class="input-effect">
          <input type="text" id="nuevoApellido" name="nuevoApellido" required>
          <label for="nuevoApellido">Apellido:</label>
        </div><br><br>
      </div>
      <div class="input-container">
        <div class="input-effect">
          <input type="number" id="nuevoCc" name="nuevoCc" required>
          <label for="nuevoCc">Cedula:</label>
        </div><br><br>
      </div>
      <div class="input-container">
        <div class="input-effect">
          <input type="number" id="nuevoTelefono" name="nuevoTelefono" required>
          <label for="nuevoTelefono">Telefono:</label>
        </div><br><br>
      </div>
      <div class="input-container">
        <div class="input-effect">
          <input type="email" id="nuevoCorreo" name="nuevoCorreo" required>
          <label for="nuevoCorreo">Correo:</label>
        </div><br><br>
      </div>
      
      <div class="input-container">
      <div class="input-effect">
        <input type="password" id="nuevaContrasena" name="nuevaContrasena" required>
        <label for="nuevaContrasena">Contrasena:</label>
      </div><br><br>
      </div>
      <button class="ini" type="submit" name="registro">Registrarse</button><br><br>
      <button class="ini" id="reg">volver </button><br><br><br>
    </form>
  </div>
<script>
    // JavaScript para manejar el clic en el botón y la redirección
    var boton = document.getElementById('reg');
          boton.addEventListener('click', function() {
          window.location.href = '../php/inicio.php'; // Cambia esta URL a la página a la que deseas redirigir
    });
</script>
    </form>
    </div>
    </div>



</body>
</html>
