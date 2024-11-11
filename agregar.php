<?php
include 'conexion.php'; // Asegúrate de que la conexión esté configurada correctamente

header('Content-Type: application/json'); // Configurar encabezado para JSON

// Verificar si se recibieron todos los datos necesarios
if (isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $proveedor = $_POST['proveedor'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $ubicacion = $_POST['ubicacion'];
    $codigo_barras = $_POST['codigo_barras'];
    $estado = $_POST['estado'];

    // Preparar la consulta para insertar el producto
    $sql = "INSERT INTO productos (nombre, descripcion, categoria, proveedor, precio, cantidad, ubicacion, codigo_barras, estado, fecha_ingreso)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, CURDATE())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdiiss", $nombre, $descripcion, $categoria, $proveedor, $precio, $cantidad, $ubicacion, $codigo_barras, $estado);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Producto agregado exitosamente"]);
    } else {
        echo json_encode(["error" => "Error al agregar el producto: " . $stmt->error]);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(["error" => "Faltan datos para agregar el producto."]);
}

// Cerrar la conexión
$conn->close();
?>
