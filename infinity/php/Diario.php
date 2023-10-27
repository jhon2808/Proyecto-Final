<?php
session_start();
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: ../html/index.html");
    exit();
}

$nombreUsuario = $_SESSION['nombre_usuario'];

// Conectar a la base de datos (incluye tu archivo de conexión)
include 'db.php';

// Consulta para obtener todos los productos
$sql = "SELECT * FROM diario";
$result = $conn->query($sql);
      
// Consulta para obtener todos los productos o filtrar por nombre de actividad
if (isset($_POST["mostrarTodo"])) {
    $sql = "SELECT * FROM diario";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreBusqueda = $_POST["nombreBusqueda"];
    $sql = "SELECT * FROM diario WHERE nombre LIKE '%" . $nombreBusqueda . "%'";
} else {
    $sql = "SELECT * FROM diario";
}

$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario.css">
    <title>Diario</title>
</head>
<body>
<table>
    <section class="btn">
        <section class="aju">
        <form method="post" action="Diario.php"> <!-- Cambia el valor de "action" para que apunte a la misma página -->
        <input class="lle" type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Actividad" required>
        <input class="pri" type="submit" value="Buscar" name="btnbuscar">
        <button class="pri" type="button" name="mostrarTodo" id="mostrarTodo">Mostrar Todo</button>
        <script>
            var btnMostrarTodo = document.getElementById('mostrarTodo');
            btnMostrarTodo.addEventListener('click', function() {
            document.querySelector('form').submit();
            });
        </script>
        </form>
        </section>
        <button class="pri" id="ag">Agregar</button>
        <script>
            // JavaScript para manejar el clic en el botón y la redirección
            var btnag = document.getElementById('ag');
            btnag.addEventListener('click', function() {
                window.location.href = 'agregar_diario.php';
                // Cambia esta URL a la página a la que deseas redirigir
            });
        </script>

        <button id="vol" class="pri">Volver</button>
        <script>
            // JavaScript para manejar el clic en el botón y la redirección
            var btnag = document.getElementById('vol');
            btnag.addEventListener('click', function() {
                window.location.href = 'inicio.php';
                // Cambia esta URL a la página a la que deseas redirigir
            });
        </script>
    </section>
    <br>
        <tr>
        <th colspan="7">DIARIO MARSELLA</th>
        </tr>
        <tr class="tab">
            <th>Registro</th>
            <th>Fecha</th>
            <th>Actividad</th>
            <th>Descripción</th>
            <th>Trabajador</th>
            <th>Fornales</th>
            <th>Acciones</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["iddiario"] . "</td>";
                echo "<td>" . $row["fecha"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["trabajador"] . "</td>";
                echo "<td>" . $row["fornal"] . "</td>";
                echo "<td><a href='editar_diario.php?id=" . $row["iddiario"] . "' >Editar</a> | <a href='eliminar_diario.php?id=" . $row["iddiario"] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No se encontraron productos.</td></tr>";
        }
        ?>
</table>

</body>
</html>