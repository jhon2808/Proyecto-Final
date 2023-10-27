<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idproducto = $_POST["idproducto"];
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $cantidad = $_POST["cantidad"];
    $lugar = $_POST["lugar"];
    $person =$_POST['person'];

    // Actualizar el producto en la base de datos
    $sql = "UPDATE producto SET nombre= ?, descripcion=?, fecha = ?, cantidad = ?,  lugar = ?, persona = ? WHERE idproducto = ?";
    $stmt = $conn->prepare($sql) or die($conn->error);
    $stmt->bind_param("ssssssi", $nombre, $descripcion, $fecha, $cantidad, $lugar, $person, $idproducto);
    if ($stmt->execute()) {
        header("Location: inventario.php");
        exit();
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
} elseif (isset($_GET["id"])) {
    // Obtener el ID del producto desde la URL
    $id = $_GET["id"];

    
    $sql = "SELECT * FROM producto WHERE idproducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario.css">

    <title>Editar Producto</title>
</head>
<body class="fom">
    <h2>Editar Producto</h2>
    <form class="" method="post" action="editar_inventario.php">

    <input type="hidden" name="idproducto" value="<?= $row["idproducto"] ?>">

        <label for="">Nombre:</label><br>
        <input type="text" id="n" name="nombre" value="<?= $row["nombre"] ?>" required><br>

        <label for="">Descripcion:</label><br>
        <input type="text" id="n" name="descripcion" value="<?= $row["descripcion"] ?>" required><br>

        <label for="">Fecha:</label><br>
        <input type="date" id="n" name="fecha" value="<?= $row["fecha"] ?>" required><br>

        <label for="">Cantidad en kg:</label><br>
        <input type="number" id="n" name="cantidad" value="<?= $row["cantidad"] ?>" required><br>

        <label for="">Lugar:</label><br>
        <input type="text" id="n" name="lugar" value="<?= $row["lugar"] ?>" required><br><br>

        <input type="hidden" id="n" name="person" value="<?= $row["persona"] ?>" required><br><br>

        <input id="bb" class="pri" type="submit" value="Guardar Cambios">
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
