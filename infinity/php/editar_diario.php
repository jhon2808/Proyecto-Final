<?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $iddiario = $_POST["iddiario"];
        $fecha = $_POST["fecha"];
        $actividad = $_POST["actividad"];
        $descripcion = $_POST["descripcion"];
        $trabaj = $_POST["trabaj"];
        $forn = $_POST["forn"];

        // Actualizar el diario en la base de datos
        $sql = "UPDATE diario SET fecha = ?, nombre = ?, descripcion = ?, trabajador = ?, fornal = ? WHERE iddiario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii",$fecha, $actividad, $descripcion, $trabaj, $forn, $iddiario); 
        if ($stmt->execute()) {
            header("Location: Diario.php");
            exit();
        } else {
            echo "Error al actualizar el producto: " . $conn->error;
        }
    } elseif (isset($_GET["id"])) {
        // Obtener el ID del producto desde la URL
        $id = $_GET["id"];

        // Consulta para obtener los datos del diario
        $sql = "SELECT * FROM diario WHERE iddiario = ?";
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
            <form class="" method="post" action="editar_diario.php">

                <input type="hidden" name="iddiario" value="<?= $row["iddiario"] ?>">
                <label for="">Fecha:</label><br>
                <input type="date" id="n" name="fecha" value="<?= $row["fecha"] ?>" required><br>

                <label for="">Actividad:</label><br>
                <input type="text" id="n" name="actividad" value="<?= $row["nombre"] ?>" required><br>

                <label for="">Descripción:</label><br>
                <textarea id="n" name="descripcion"><?= $row["descripcion"] ?></textarea><br>

                <label for="">Precio:</label><br>
                <input type="text" id="n" name="trabaj"  value="<?= $row["trabajador"] ?>" required><br>

                <label for="">Unidad:</label><br>
                <input type="number" id="n" name="forn" value="<?= $row["fornal"] ?>" required><br><br>

                <input id="bb" class="pri" type="submit" value="Guardar Cambios">
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
