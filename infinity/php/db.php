<?php
$conn=mysqli_connect("localhost","root","","fm");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
