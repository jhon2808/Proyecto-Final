<!DOCTYPE html>
<html>
<head lang="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/stiles.css">
  <title>Iniciar Sesión</title>
</head>
<body>
  <div class="asd" id="f1"><br>
    <h2>Iniciar Sesion</h2><br><br>
    <form action="login.php" method="post">
      <div class="input-container">
        <div class="input-effect">
          <input type="email" id="usu" name="usuario" required>
          <label for="usu">Corrreo:</label>
        </div><br><br>
      </div>

      <div class="input-container">
        <div class="input-effect">
          <input type="password" id="contrasena" name="contrasena" required>
          <label for="contrasena">Contrasena:</label>
        </div>
      </div><br><br>

      <button class="ini" type="submit" name="login">Iniciar Sesion</button><br><br>
      <button class="ini" id="miBoton">registrarse</button><br><br>
    </form>
  </div>
  <div class="asd" id="f2" style="display:none;"><br>
    <h2>Registro</h2><br><br>
    <form action="registro.php" method="post">
      <div style="display: none;">
        <label for="rolSeleccionado">Rol:</label><br>
        <select name="rolSeleccionado" id="rolSeleccionado" required>
        <option value="2">Operador</option>
        </select><br><br>
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
      <button class="ini" id="regre">volver </button>
    </form>
  </div>
  <script src="../script/js.js"></script>
</body>
</html>
