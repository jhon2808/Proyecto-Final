<?php
$conn=mysqli_connect("localhost","root","","img");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$nom = $_POST['nombre'];
$tip = $_POST['tipo'];
$img = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));

$query = "INSERT INTO imagenes (nombre, tipo, imagen) VALUES ('$nom', '$tip', '$img')";
$resultado = $conn->query($query);
if($resultado){
    echo"si se inserto ";
}
else{
    echo"no se inserto";
}

?>