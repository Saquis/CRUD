<?php
include 'conexion.php'; // Asegúrate de que la conexión esté configurada correctamente

// Verificar si se recibió el ID del producto
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Preparar la consulta para eliminar el producto
    $sql = "DELETE FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Producto eliminado exitosamente";
    } else {
        echo "Error al eliminar el producto: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
} else {
    echo "ID de producto no proporcionado.";
}

// Cerrar la conexión
$conn->close();
?>
