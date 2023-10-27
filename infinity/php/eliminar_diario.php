<?php
include 'db.php';

if (isset($_GET["id"])) {
    // Obtener el ID del producto desde la URL
    $idproducto = $_GET["id"];

    // Consulta para eliminar el producto
    $sql = "DELETE FROM diario WHERE iddiario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idproducto);

    if ($stmt->execute()) {
        header("Location: Diario.php"); // Redirigir a la lista de productos
        exit();
    } else {
        echo "Error al eliminar el dato: " . $conn->error;
    }
} else {
    echo " dato no proporcionado.";
}
?>
