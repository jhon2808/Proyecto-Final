<?php
session_start();

include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombreProducto = $_POST['idproducto'];
    $descripcionProducto = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
    $estado = $_POST['activ'];

    // Validación de datos (asegúrate de que los campos requeridos estén completos)
    if (empty($nombreProducto) || empty($descripcionProducto) || empty($cantidad)) {
        echo "Por favor, complete todos los campos.";
    } else {
        // Consulta SQL para buscar el producto por nombre y descripción
        $sqlproducto = "SELECT idproducto FROM producto WHERE idproducto = ? AND descripcion = ?";
        $stmtproducto = $conn->prepare($sqlproducto);
        $stmtproducto->bind_param("ss", $nombreProducto, $descripcionProducto);
        $stmtproducto->execute();
        $stmtproducto->store_result();

        if ($stmtproducto->num_rows > 0) {
            $stmtproducto->bind_result($producto_id);
            $stmtproducto->fetch();

            die($producto_id);

            // Consulta SQL para verificar si el producto ya tiene un precio asociado
            $sqlverificar = "SELECT producto_idproducto, cantidad FROM precio WHERE producto_idproducto = ?";
            $stmtverificar = $conn->prepare($sqlverificar);
            $stmtverificar->bind_param("i", $producto_id);
            $stmtverificar->execute();
            $stmtverificar->store_result();

            if ($stmtverificar->num_rows > 0) {
                $stmtverificar->bind_result($producto_id_existente, $cantidad_existente);
                $stmtverificar->fetch();

                // Actualizar la cantidad sumando la cantidad existente con la nueva cantidad
                $cantidad_total = $cantidad + $cantidad_existente;

                $sqlactualizarcantidad = "UPDATE precio SET cantidad = ? WHERE producto_idproducto = ?";
                $stmtactualizarcantidad = $conn->prepare($sqlactualizarcantidad);
                $stmtactualizarcantidad->bind_param("ii", $cantidad_total, $producto_id_existente);
                $stmtactualizarcantidad->execute();

                if ($stmtactualizarcantidad->affected_rows > 0) {
                    header("location: productos.php");
                } else {
                    echo "<p class='men'>Error al actualizar la cantidad.</p>";
                }
            } else {
                // El producto no tiene un precio asociado, puedes insertar la cantidad
                $sqlprecio = "INSERT INTO precio (cantidad, activado, producto_idproducto) VALUES (?, ?, ?)";
                $stmtprecio = $conn->prepare($sqlprecio);
                $stmtprecio->bind_param("iii", $cantidad, $estado, $producto_id);
                $stmtprecio->execute();

                if ($stmtprecio->affected_rows > 0) {
                    header("location: productos.php");
                } else {
                    echo "Error al insertar el precio: ";
                }
            }
        } else {
            echo "<p class='men'>No se encontró un producto con ese nombre y descripción.</p>";
        }
    }
}

// Consulta SQL para obtener productos que no tienen precios asociados
$sqlProductosDisponibles = "SELECT idproducto, nombre, descripcion FROM producto 
                           WHERE idproducto NOT IN (SELECT producto_idproducto FROM precio)";
$resultProductos = $conn->query($sqlProductosDisponibles);

// Cerrar la conexión a la base de datos
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/inventario.css">
    <title>Agregar a la venta</title>

</head>
<body class="fom">
    <h2>Agregar a la venta</h2>
    <form action="agregar_pro.php" method="post">
        <label for="nombre">Nombre del producto</label><br>
        <input type="text" name="idproducto" list="listas" id="www" placeholder="nombre de producto" required>
         <datalist id="listas">
         <?php 
            if ($resultProductos->num_rows > 0) {
                while ($row = $resultProductos->fetch_assoc()) {
                    echo "<option value='{$row['idproducto']} '>({$row['nombre']}_{$row['descripcion']})</option>" ;
                }
            } else {
                echo "<option value=''>No hay productos disponibles sin precio</option>";
            }
            ?>
         </datalist><br>
        <label for="descripcion">Descripción del producto</label><br>
        <input type="text" name="descripcion" required><br>

        <input type="number" id="n" name="cantidad" value="<?= $row["cantidad"] ?>" ><br><br>


        <label for="precio">Precio por unidad del producto</label><br>
        <input type="text" name="precio" required><br>
        <label for="activ">Estado</label><br>
        <select name="activ" id="activ">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select><br><br>
        <input type="submit" value="Agregar"><br><br>
        <a class="volv" href="productos.php" type="button"> &nbsp;volver&nbsp;</a>
    </form>
</body>
</html>
