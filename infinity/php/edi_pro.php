<?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nuevoPrecio = $_POST["precio"];
        $nombreProducto = $_POST["nombre"]; // Nombre del producto
    
        // Desactivar el precio actual para productos con el mismo nombre y activados
        $sqlDesactivarPrecio = "UPDATE precio
            INNER JOIN producto ON precio.producto_idproducto = producto.idproducto
            SET precio.activado = 0
            WHERE producto.nombre = ? AND precio.activado = 1";
        
        $stmtDesactivarPrecio = $conn->prepare($sqlDesactivarPrecio);
        $stmtDesactivarPrecio->bind_param("s", $nombreProducto);
    
        if ($stmtDesactivarPrecio->execute()) {
            // Ahora, insertar el nuevo precio para productos con el mismo nombre
            $sqlInsertarPrecio = "INSERT INTO precio (precio, activado, producto_idproducto)
                SELECT ?, 1, p.idproducto
                FROM producto p
                INNER JOIN precio pr ON p.idproducto = pr.producto_idproducto
                WHERE p.nombre = ?";
            
            $stmtInsertarPrecio = $conn->prepare($sqlInsertarPrecio);
            $stmtInsertarPrecio->bind_param("ss", $nuevoPrecio, $nombreProducto);
    
            if ($stmtInsertarPrecio->execute()) {
                header("Location: productos.php"); // Redirige a la página de productos
                exit();
            } else {
                echo "Error al insertar el nuevo precio: " . $conn->error;
            }
        } else {
            echo "Error al desactivar el precio actual: " . $conn->error;
        }
    }
    
    // Resto de tu código para obtener el nombre del producto
    
     if (isset($_GET["nombrep"])) {
        $nombrep = $_GET["nombrep"];
    } else {
        echo "Los valores nombre del producto estan vacios.";
    }
    
    $sql = "SELECT pro.nombre npro, pro.descripcion dpro, SUM(pro.cantidad) AS cpro, pre.precio ppro FROM  precio pre INNER join producto pro ON pro.idproducto = pre.producto_idproducto
    WHERE pro.nombre = ? " ;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombrep);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        } else {
        echo "Producto no encontrado.";
        exit();
    }
    
    
?>
<!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../css/inventario.css">
            
            <title>Editar Producto</title>
        </head>
        <body class="fom">
            <h2>Actualizar el precio del producto</h2>
            <form class="mod" method="post" action="edi_pro.php">
            <label for="">Nombre: <?= $row["npro"] ?></label><br>
            
            <input type="hidden" id="n" name="nombre" value="<?= $row["npro"] ?>" required><br>


            <label for="">cantidad:  <?= $row["cpro"] ?></label><br><br>

            <input type="text" id="n" name="precio" value="<?= $row["ppro"] ?>" required><br><br>

            <input id="bb" class="pri" type="submit" value="Guardar Cambios">
            </form>
            <br>  
            
            <br>
            <button id="j" class="pri">Volver</button>
                <script>
                    // JavaScript para manejar el clic en el botón y la redirección
                    var btnag = document.getElementById('j');
                    btnag.addEventListener('click', function() {
                        window.location.href = 'productos.php';
                        // Cambia esta URL a la página a la que deseas redirigir
                    });
                </script>
        </body>
    </html>
