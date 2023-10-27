<?php

// Conectar a la base de datos (incluye tu archivo de conexión)
include 'db.php';


session_start();
if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: ../html/index.html");
    exit();
}

$nombreUsuario = $_SESSION['nombre_usuario'];



// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $cantidad = $_POST["cantidad"]; // Cambié el nombre de la variable
    $lugar = $_POST["lugar"];

    // Insertar el nuevo producto en la base de datos
    $sql = "INSERT INTO producto (nombre, descripcion, fecha, cantidad, lugar, persona) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $descripcion, $fecha, $cantidad, $lugar, $nombreUsuario);
    $stmt->execute();
    $idDelProducto = $conn->insert_id;

    if ($stmt->affected_rows > 0) {
        $precio = $_POST["precio"];
        $activado = $_POST["activ"];

        // Insertar el precio relacionado con el producto
        $sqlp = "INSERT INTO precio (precio, activado, producto_idproducto) VALUES (?, ?, ?)";
        $stmtp = $conn->prepare($sqlp);
        $stmtp->bind_param("iii", $precio, $activado, $idDelProducto);
        $stmtp->execute();
        $idDelPrecio = $conn->insert_id;

        if ($stmtp->affected_rows > 0) {
            // El precio se insertó correctamente
            header("location: inventario.php");
        } else {
            echo "Error al insertar el precio: " . $conn->error;
        }
    } else {
        echo "Error al insertar el producto: " . $conn->error;
    }

    $stmt->close();
    $stmtp->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario.css">

    <title>Agregar</title>
</head>
<body class="fom">
    <h2>Agregar</h2>
    <form  method="post" action="agregar_inventario.php">

        <label for="">Nombre:</label> <br>
        <input type="text" id="n" name="nombre" required><br>

        <label for="">Descripcion:</label> <br>
        <textarea id="n" name="descripcion" required></textarea><br>

        <label for="">Fecha:</label> <br>
        <input type="date" id="n" name="fecha" required><br>

        <label for="">Cantidad en KG:</label><br>
        <input type="number" id="n" name="cantidad" required><br>

        <label for="">precio por KG:</label><br>
        <input type="text" id="n" name="precio" required><br>

        <select style="display: none;" name="activ" id="activ">
            <option value="1">Activo</option>
        </select><br>

        <label for="">Lugar:</label><br>
        <input type="text" id="n" name="lugar" required><br><br>


        <input id="bb" class="pri" type="submit" value="Agregar">
    </form>
    <br>
    <button id="j" class="pri">Volver</button>
        <script>
            // JavaScript para manejar el clic en el botón y la redirección
            var btnag = document.getElementById('j');
            btnag.addEventListener('click', function() {
                window.location.href = 'inventario.php';
                // Cambia esta URL a la página a la que deseas redirigir
            });
        </script>
</body>
</html>
