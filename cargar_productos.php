<?php
// Datos de conexión
$host = "127.0.0.1";
$dbname = "inventario_tienda"; // Asegúrate de que esta base de datos existe
$username = "root";
$password = "";

// Crear conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die(json_encode(["error" => "Error en la conexión: " . $conn->connect_error]));
}

// Realizar una consulta
$sql = "SELECT * FROM productos"; // Consulta a la tabla "productos"
$result = $conn->query($sql);

$productos = []; // Array para almacenar los productos

// Verificar si hay resultados y si la consulta fue exitosa
if ($result && $result->num_rows > 0) {
    // Guardar los resultados en el array
    while($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} else if ($result->num_rows === 0) {
    $productos = ["message" => "No hay productos disponibles"];
} else {
    $productos = ["error" => "Error en la consulta: " . $conn->error];
}

// Cerrar conexión
$conn->close();

// Enviar los datos en formato JSON
header('Content-Type: application/json');
echo json_encode($productos);
?>
