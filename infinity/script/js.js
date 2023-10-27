// JavaScript para manejar el clic en el botón y la redirección
var boton = document.getElementById('regre');
boton.addEventListener('click', function() {
window.location.href = 'lyr.php'; // Cambia esta URL a la página a la que deseas redirigir
});

// JavaScript para manejar el clic en el botón y la redirección
var boton = document.getElementById('miBoton');
var f2 = document.getElementById("f2");
var f1 = document.getElementById("f1");

    boton.addEventListener('click', function() {
    f2.style.display = 'block';
    boton.style.display = 'none';
    f1.style.display ='none';
});