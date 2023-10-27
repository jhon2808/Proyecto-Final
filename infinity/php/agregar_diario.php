<?php
// Conectar a la base de datos (incluye tu archivo de conexión)
include 'db.php';

// Procesar el formulario cuando se envíe
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST["fecha"];
    $actividad = $_POST["actividad"];
    $descripcion = $_POST["descripcion"];
    $trabaj = $_POST["trabaj"];
    $forn = $_POST["forn"];

    // Insertar el nuevo producto en la base de datos
    $sql = "INSERT INTO diario (fecha, nombre, descripcion, trabajador, fornal) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $fecha, $actividad, $descripcion, $trabaj, $forn); // "ssdi" indica tipos de datos

    if ($stmt->execute()) {
        header("Location: Diario.php"); // Redirigir a la lista de productos
        exit();
    } else {
        echo "Error al agregar el producto: " . $conn->error;
    }

    $stmt->close();
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
    <form  method="post" action="agregar_diario.php">

        <label for="">Fecha:</label> <br>
        <input type="date" id="n" name="fecha" required><br>

        <label for="">Actividad:</label> <br>
        <input type="text" id="n" name="actividad" required><br>
        
        <label for="">Descripción:</label><br>
        <textarea id="n" name="descripcion" required></textarea><br>

        <label for="">Trabajador:</label><br>
        <input type="text" id="n" name="trabaj" required><br>

        <label for="">Fornales:</label><br>
        <input type="number" id="n" name="forn" required><br><br>

        <input id="bb" class="pri" type="submit" value="Agregar">
    </form>
    <br>
    <button id="j" class="pri">Volver</button>
        <script>
            // JavaScript para manejar el clic en el botón y la redirección
            var btnag = document.getElementById('j');
            btnag.addEventListener('click', function() {
                window.location.href = 'Diario.php';
                // Cambia esta URL a la página a la que deseas redirigir
            });
        </script>
</body>
</html>
