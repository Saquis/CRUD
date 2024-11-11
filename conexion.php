<?php
$host = "127.0.0.1";          // Dirección local de MySQL en XAMPP
$dbname = "inventario_tienda"; // Nombre de la base de datos
$username = "root";            // Usuario predeterminado en XAMPP
$password = "";                // Contraseña predeterminada vacía en XAMPP

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error en la conexión: " . $conn->connect_error]));
}

// Realizar una consulta
$sql = "SELECT * FROM productos"; // Consultar todos los registros en la tabla "productos"
$result = $conn->query($sql);

$productos = [];

// Verificar si la consulta fue exitosa
if ($result === false) {
    die(json_encode(["error" => "Error en la consulta: " . $conn->error]));
}

if ($result->num_rows > 0) {
    // Guardar los resultados en un array
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

// Cerrar conexión
$conn->close();

// Enviar encabezado de contenido JSON
header('Content-Type: application/json');

// Convertir los datos a JSON y enviarlos a JavaScript
echo json_encode($productos);
exit(); // Asegurar que no haya salida extra
?>
