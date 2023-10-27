<?php
include 'db.php';

if (isset($_GET["id"])) {
    // Obtener el ID del producto desde la URL
    $idproducto = $_GET["id"];

    // Consulta para eliminar el producto
    $sql = "DELETE FROM producto WHERE idproducto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idproducto);

    if ($stmt->execute()) {
        header("Location: inventario.php"); // Redirigir a la lista de productos
        exit();
    } else {
        echo "No se puede borrar porque tiene un precio agregado";
        echo '<a href="inventario.php" class="boton">Volver</a>';        
    }
} else {
    echo " dato no proporcionado.";
}
?>
