<?php
include 'conexion.php';

header('Content-Type: application/json');

// Verificar si se recibieron los datos del formulario
if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['cantidad'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $categoria = $_POST['categoria'];
    $proveedor = $_POST['proveedor'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $ubicacion = $_POST['ubicacion'];
    $codigo_barras = $_POST['codigo_barras'];
    $estado = $_POST['estado'];

    // Preparar la consulta de actualización
    $sql = "UPDATE productos SET nombre=?, descripcion=?, categoria=?, proveedor=?, precio=?, cantidad=?, ubicacion=?, codigo_barras=?, estado=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdiissi", $nombre, $descripcion, $categoria, $proveedor, $precio, $cantidad, $ubicacion, $codigo_barras, $estado, $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Producto actualizado exitosamente"]);
    } else {
        echo json_encode(["error" => "Error al actualizar el producto: " . $stmt->error]);
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo json_encode(["error" => "Datos del producto no proporcionados correctamente"]);
}

// Cerrar la conexión
$conn->close();
?>
