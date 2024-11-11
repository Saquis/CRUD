<?php
$host = "127.0.0.1";          // Dirección local de MySQL en XAMPP
$dbname = "inventario_tienda"; // Nombre de la base de datos
$username = "root";            // Usuario predeterminado en XAMPP
$password = "";                // Contraseña predeterminada vacía en XAMPP

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}
?>
