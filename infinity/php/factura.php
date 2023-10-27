<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>venta</title>
</head>
<body>
    
<?php
if (isset($_POST["comprar"])) {
    $nombreProducto = $_POST["nombre"];
    $canti = $_POST["canti"];
    $precio = $_POST["precio"];
    $precioTotal = $canti * $precio;
}else {
    echo "Manejo de error si los parámetros no están presentes.";
    // Manejo de error si los parámetros no están presentes.
}
?>

<form action="" method="post">
    <label for="nombre">Nombre del producto:</label><br />
    <input type="text" name="nombre" value="<?= $nombreProducto ?>"><br />
    <label for="cantidad">Cantidad:</label><br />
    <input type="number" name="cantidad" min="1" max="9999" step="any" value="<?= $canti ?>"><br>
    <label for="">Precio: </label><br>
    <input type="number" name="cantidad" min="1" max="9999" step="any" value="<?= $precio ?>"><br>
    <label for="">Precio Total: </label><br>
    <input type="number" name="cantidad" min="1" max="9999" step="any" value="<?= $precioTotal ?>"><br>
    <button type="submit">Enviar</button>


</form>
</body>
</html>
