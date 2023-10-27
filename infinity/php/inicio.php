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
  GROUP BY pro.nombre;";
  $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website Icon" type="png" href="../img/jec.png">
    <link rel="stylesheet" href="../css/producto.css">

    <title>Web</title>
  </head>
  <body>
    <header>
      <div class="loga"><h1>Finca_Marsella &nbsp; <?php echo $nombreUsuario; ?> </div>
      <nav>
        <div class="hamburger-menu" id="hamburger-menu">
          <div class="bar"></div>
          <div class="bar"></div>
          <div class="bar"></div>
        </div>
        <ul class="nav-links" id="nav-links">
          <li class="text-with-line"><a href="inicio.php" >Inicio</a></li>
          <li class="text-with-line" id="inven"><a href="inventario.php">inventario</a></li>
          <li class="text-with-line" id="Dia"><a href="Diario.php">Diario</a></li>
          <li class="text-with-line" id="pro"><a href="productos.php">Productos</a></li>
          <li class="text-with-line" id="rnu"><a href="reg.php">registro</a></li>
          <li class="text-with-line"><a href="contactos.php">Contacto</a></li>
          <li class="text-with-line"><a href="logout.php">Cerrar sesion</a></li>
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
    <section >
          <script>
              var divad = document.getElementById("divad");
              var divop = document.getElementById("divop");
              var inven = document.getElementById("inven");
              var Dia = document.getElementById("Dia");
              var rnu = document.getElementById("rnu");
              var pro = document.getElementById("pro");

              // Mostrar u ocultar el div según el rol
              <?php
              if ($_SESSION["rol_usuario"] === "Admin") {
                echo "divad.style.display = 'block';";
                echo "divop.style.display = 'none';";

              } elseif ($_SESSION["rol_usuario"] === "Operador") {
                echo "inven.style.display = 'none';";
                echo "rnu.style.display = 'none';";
                echo "divad.style.display = 'none';";
                echo "Dia.style.display = 'none';";
                echo "divop.style.display = 'block';";
                echo "pro.style.display = 'none';";

              }
              ?>
        </script>
    </section>
    <?php
echo "<section class='ccc'>";
echo "<div class='cccc'>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $precioTotal = $row["cantidad"] * $row["precio"];
        echo "<div class='coon'>";
        echo "<div class='coon1'>";
        echo "<p>imagen</p>";
        echo "</div>";
        echo "<div class='coon2'>";
        echo "<h3>" . $row["nombre"] . "</h3>";
        echo "<p> Disponibles:  "  . $row["cantidad"] . " Kilogramos</p>";
        echo "<p> Precio por Kilogramo: $" . $row["precio"] . "</p>";
        echo "<div class='quantity-input'>";
        ?>
        <form method="post" action="factura.php">
        <input type="hidden" name="nombre" value="<?= $row["nombre"] ?>">
        <input type="hidden" name="precio" value="<?= $row["precio"] ?>">
        <div class="inf">
        <?php 
        echo "Cantidad";
        echo "<div class='quantity-button' onclick='decrementQuantity(this)'>-</div>";?>
        <input type="number" name="canti" class="cantidad-input" value="1" min="1" data-cantidad="<?= $row["cantidad"] ?>" data-precio="<?= $row["precio"] ?>" oninput="updateTotal(this)">
        KG
        <?php echo "<div  class='quantity-button' onclick='incrementQuantity(this)'>+</div><br>";?><br>
        
        </div>
        <p class='precio-total'>Precio Total: <span class='total-amount'>$<?= $row["precio"] ?></span></p>

        <button type="submit" class="compra" name="comprar">Comprar</button>
        </form>
        

        <?php   
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
echo "</div>";
echo "</section>";
?>


<script>
function updateTotal(input) {
    var cantidadDeseada = input.value;
    var precioUnitario = parseFloat(input.getAttribute("data-precio"));
    var precioTotal = precioUnitario * cantidadDeseada;

    var precioTotalElement = input.parentElement.parentElement.querySelector(".total-amount");
    precioTotalElement.textContent = "$" + precioTotal;
}


function incrementQuantity(button) {
    console.log("Incrementando cantidad");
    var input = button.parentElement.querySelector(".cantidad-input");
    var cantidadDeseada = parseInt(input.value) + 1;
    var cantidadDisponible = parseInt(input.getAttribute("data-cantidad"));
    if (cantidadDeseada <= cantidadDisponible) {
        input.value = cantidadDeseada;
        updateTotal(input);
    }
}


function decrementQuantity(button) {
    var input = button.parentElement.querySelector(".cantidad-input");
    var cantidadDeseada = parseInt(input.value) - 1;
    if (cantidadDeseada >= 1) {
        input.value = cantidadDeseada;
        updateTotal(input);
    }
}


</script>



    
  </body>
</html>

