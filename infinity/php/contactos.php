<?php
  session_start();
  if (!isset($_SESSION["nombre_usuario"])) {
    header("Location: ../html/index.html");
    exit();
  }

  $nom = $_SESSION['nombre_usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/conn.css">
    <title>Contacto</title>
</head>
<body>
<header>
      <div class="loga"><h1>Finca_Marsella</h1><p class="nom"><?php echo $nom; ?> </p> </div>
      <nav>
        <div class="hamburger-menu" id="hamburger-menu">
          <div class="bar"></div>
          <div class="bar"></div>
          <div class="bar"></div>
        </div>
        <ul class="nav-links" id="nav-links">
          <li class="text-with-line"><a href="contactos.php" >Inicio</a></li>
          <li class="text-with-line" id="inven"><a href="inicio.php">volver</a></li>
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
<section class="connn">
<div class="con">
    <div class="c"> <h1> Contactos</h1>  </div>
    <div class="c"> <h4>Telefono: 3242508155</h4>  </div>
    <div class="c"> <h4>Whatsapp: +573242508155</h4>  </div>
    <div class="c"> <h4>Correo:   jonathanquintero2808@gmail.com</h4>  </div>
    <div class="c"> <h4>Facebook: Jonathan Quintero (Jhon Quin)</h4>  </div>
    <div class="c"> <h4>Twitter:  @Jonathan35604205 </h4>  </div>
    <div class="c"> <h4>Instagram: jonathanquintero2808</h4>  </div>
    <div class="c"> <h4>Linkendln:  Jonathan Quintero </h4>  </div>
    <div class="c"> <h4>Direccion: Cra 2 #18-30 Caracolí ( Puerto boyaca Boyacá Colombia ) </h4>  </div>
</div>
<div>
    <div></div>
</div>
</section>
</body>
</html>