<?php
  session_start();
  if (!isset($_SESSION["nombre_usuario"])) {
      header("Location: ../html/index.html");
      exit();
  }
  $nombreUsuario = $_SESSION['nombre_usuario'];

// Conectar a la base de datos (incluye tu archivo de conexión)
include 'db.php';

// Consulta para obtener todos los productos del inventario
$sql = "SELECT pro.nombre, SUM(pro.cantidad) AS cantidad, pre.precio
FROM precio pre
INNER JOIN producto pro ON pro.idproducto = pre.producto_idproducto
WHERE pre.activado = 1
GROUP BY pro.nombre; ";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/pro.css">
    <title>Productos</title>
</head>
<body>
<header>
    <div class="loga"><h1>Finca_Marsella &nbsp;&nbsp;&nbsp; <?php echo $nombreUsuario; ?></h1></div>
      <nav>
        <div class="hamburger-menu" id="hamburger-menu">
          <div class="bar"></div>
          <div class="bar"></div>
          <div class="bar"></div>
        </div>
        <ul class="nav-links" id="nav-links">
        <li class="text-with-line"><a class="ln" href="productos.php">Inicio</a></li>
        <li class="text-with-line"><a class="ln" href="inicio.php">Volver</a></li>
        <li class="text-with-line"><a class="ln" href="inventario.php">Inventario</a></li>
        </ul>
        <script>
          const hamburgerMenu = document.getElementById("hamburger-menu");
          const navLinks = document.getElementById("nav-links");
          const des = document.getElementById("carousel-navigation");

          hamburgerMenu.addEventListener("click", () => {
          navLinks.classList.toggle("active");
          });

          // Agregar un evento de clic a cada enlace del menú para ocultar el menú
          const menuLinks = document.querySelectorAll(".nav-links a");

          menuLinks.forEach(link => {
          link.addEventListener("click", () => {
          navLinks.classList.remove("active");

          });
          });


        </script>
      </nav>
</header>

<div>
  <table>
    <br>
        <tr>
        <th colspan="8"><h2>pruducto en venta</h2></th>
        </tr>
        <tr class="tab">
        <th>  Nombre &nbsp; </th>
        <th>  Cantidad &nbsp;   </th>
        <th>  Precio por KG &nbsp;   </th>
        <th>  Precio total &nbsp;   </th>
        <th>  Acciones  </th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              // código para mostrar los registros
              echo "<tr> "; 
              echo "<td> &nbsp;&nbsp;" . $row["nombre"] . "</td>";
              echo "<td>" . $row["cantidad"] ."&nbsp; KG &nbsp;", "</td>";
              echo "<td>" . $row["precio"] . "</td>";
              // Calcular el precio total
              $pTotal = $row["cantidad"] * $row["precio"];
              echo "<td>" . $pTotal . "</td>";
              echo "<td><a href='edi_pro.php?nombrep=" . $row["nombre"] . "'>Actualizar precio</a></td>";
              echo "</tr>";
          }}
          else {
            echo "<tr><td colspan='9'>No se encontraron productos.</td></tr>";
        }


          
          
          
          ?>
  </table>
</div>
</body>
</html>