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
$sql = "SELECT pre.idprecio, pro.idproducto, pro.nombre, pro.descripcion, pro.fecha, pro.cantidad, pro.lugar, pro.persona, pre.precio, pre.activado FROM  precio pre INNER join producto pro ON pro.idproducto = pre.producto_idproducto WHERE pre.activado = 1 GROUP BY pro.idproducto;";
$result = $conn->query($sql);
      
// Consulta para obtener todos los productos o filtrar por nombre de actividad
if (isset($_POST["mostrarTodos"])) {
    $sql = "SELECT pre.idprecio, pro.idproducto, pro.nombre, pro.descripcion, pro.fecha, pro.cantidad, pro.lugar, pro.persona, pre.precio, pre.activado FROM  precio pre INNER join producto pro ON pro.idproducto = pre.producto_idproducto WHERE pre.activado = 1 GROUP BY pro.idproducto;";
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreBusqueda = $_POST["nombreBusqueda"];
    $sql = "SELECT pre.idprecio, pro.idproducto, pro.nombre, pro.descripcion, pro.fecha, pro.cantidad, pro.lugar, pro.persona, pre.precio, pre.activado FROM  precio pre INNER join producto pro ON pro.idproducto = pre.producto_idproducto WHERE nombre LIKE '%" . $nombreBusqueda . "%' AND pre.activado = 1 GROUP BY pro.idproducto";
} else {
    $sql = "SELECT pre.idprecio, pro.idproducto, pro.nombre, pro.descripcion, pro.fecha, pro.cantidad, pro.lugar, pro.persona, pre.precio, pre.activado FROM  precio pre INNER join producto pro ON pro.idproducto = pre.producto_idproducto WHERE pre.activado = 1 GROUP BY pro.idproducto; ";
}

$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/inventario.css">
    <link rel="stylesheet" href="../css/pro.css">
    <title>Inventario</title>
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
        <li class="text-with-line"><a class="ln" href="inventario.php">Mostrar_Todo</a></li>
        <li class="text-with-line"><a class="ln" href="productos.php">ir_a_venta</a></li>
        <li class="text-with-line"><a class="ln" href="inicio.php">volver</a></li>
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
<section class="btn">
        <section class="aju">
        <form method="post" action="inventario.php"> 
        <input class="lle" type="text" id="nombreBusqueda" name="nombreBusqueda" placeholder="Nombre" required>
        <input class="pri" type="submit" value="Buscar" name="btnbuscar">
        </form>
        </section>
        <button class="pri" id="ag">Agregar</button>
        <script>
            // JavaScript para manejar el clic en el botón y la redirección
            var btnag = document.getElementById('ag');
            btnag.addEventListener('click', function() {
                window.location.href = 'agregar_inventario.php';
                // Cambia esta URL a la página a la que deseas redirigir
            });
        </script>

    </section>
<table>
    <br>
        <tr>
        <th colspan="9">INVENTARIO MARSELLA</th>
        </tr>
        <tr class="tab">
        <th>Registro</th>
        <th>Nombre</th>
        <th>descripcion</th>
        <th>Fecha</th>
        <th>Cantidad</th>
        <th>precio por KG</th>
        <th>lugar</th>
        <th>persona</th>
        <th>Acciones</th>
        </tr>
        <?php
        // Inicializar las variables con valores predeterminados
        $numRegistros = 0;
        $dias = 0;
        $horas = 0;
        $minutos = 0;
        $segundos = 0;
        $cantidadTotal = 0;
        $pesoTotal = 0;
        $nombresUnicos = array();

        if ($result->num_rows > 0) {
            // Obtiene la fecha más temprana y la fecha más reciente
            $fechas = [];
            $cantidadTotal = 0;
            $pesoTotal = 0;

            while ($row = $result->fetch_assoc()) {
                // código para mostrar los registros
                echo "<tr>";
                echo "<td>" . $row["idproducto"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["descripcion"] . "</td>";
                echo "<td>" . $row["fecha"] . "</td>";
                echo "<td>" . $row["cantidad"] ."&nbsp; KG &nbsp;", "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>" . $row["lugar"] . "</td>";
                echo "<td>" . $row["persona"] . "</td>";
                echo "<td><a href='editar_inventario.php?id=" . $row["idproducto"] . "' >Editar</a></td>";
                echo "</tr>";
                

                // Agregar el nombre al arreglo de nombres únicos
                $nombresUnicos[] = $row["nombre"];

                // Incrementa un contador para calcular el número de registros
                $numRegistros++;
                
                // Convierte la fecha a un formato adecuado
                $fechas[] = strtotime($row["fecha"]); 

                // Suma la cantidad y el peso
                $cantidadTotal += $row["cantidad"];
                
                // Calcula la diferencia de tiempo
                $tiempoPrimeraFecha = min($fechas);
                $tiempoUltimaFecha = max($fechas);
                $diferenciaTiempo = $tiempoUltimaFecha - $tiempoPrimeraFecha;

                // Convierte la diferencia de tiempo a días, horas, minutos y segundos
                $dias = floor($diferenciaTiempo / (60 * 60 * 24));
                $horas = floor(($diferenciaTiempo % (60 * 60 * 24)) / (60 * 60));
                $minutos = floor(($diferenciaTiempo % (60 * 60)) / 60);
                $segundos = $diferenciaTiempo % 60;

            }
            

        } else {
            echo "<tr><td colspan='9'>No se encontraron productos.</td></tr>";
        }
        ?>
</table>
<!-- Después de cerrar la etiqueta </table> -->
<div class="resultados">
    <p>N.registros: <?php echo $numRegistros; ?> 
    Tiempo: <?php echo "$dias días"; ?>
    C.total: <?php echo $cantidadTotal; ?> kg</p>

</div>

</body>
</html>