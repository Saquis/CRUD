<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id) {
        $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Producto eliminado correctamente."]);
        } else {
            echo json_encode(["error" => "Error al eliminar el producto."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["error" => "ID de producto no proporcionado."]);
    }
}

$conn->close();
exit();
