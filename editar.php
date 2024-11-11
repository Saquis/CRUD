<?php
include 'conexion.php'; // Asegúrate de que la conexión esté activa después de esta línea

// Verificar si se recibió el ID del producto
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar y ejecutar la consulta para obtener el producto
    $sql = "SELECT * FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Verificar que la preparación fue exitosa
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        echo "Producto no encontrado";
        $stmt->close();
        $conn->close();
        exit;
    }

    // Cerrar la declaración después de obtener los datos
    $stmt->close();
} else {
    echo "ID de producto no proporcionado";
    $conn->close();
    exit;
}

// Cerrar la conexión aquí después de obtener los datos
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Enlace al archivo CSS externo -->
</head>
<body>
    <h2>Editar Producto</h2>
    <form action="actualizar.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($producto['id']); ?>">
        <label>Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required></label><br>
        <label>Descripción: <input type="text" name="descripcion" value="<?php echo htmlspecialchars($producto['descripcion']); ?>"></label><br>
        <label>Categoría: <input type="text" name="categoria" value="<?php echo htmlspecialchars($producto['categoria']); ?>"></label><br>
        <label>Proveedor: <input type="text" name="proveedor" value="<?php echo htmlspecialchars($producto['proveedor']); ?>"></label><br>
        <label>Precio: <input type="number" name="precio" step="0.01" value="<?php echo htmlspecialchars($producto['precio']); ?>" required></label><br>
        <label>Cantidad: <input type="number" name="cantidad" value="<?php echo htmlspecialchars($producto['cantidad']); ?>" required></label><br>
        <label>Ubicación: <input type="text" name="ubicacion" value="<?php echo htmlspecialchars($producto['ubicacion']); ?>"></label><br>
        <label>Código de Barras: <input type="text" name="codigo_barras" value="<?php echo htmlspecialchars($producto['codigo_barras']); ?>" required></label><br>
        <label>Estado: 
            <select name="estado">
                <option value="Disponible" <?php if($producto['estado'] == 'Disponible') echo 'selected'; ?>>Disponible</option>
                <option value="Agotado" <?php if($producto['estado'] == 'Agotado') echo 'selected'; ?>>Agotado</option>
                <option value="Descontinuado" <?php if($producto['estado'] == 'Descontinuado') echo 'selected'; ?>>Descontinuado</option>
            </select>
        </label><br>
        <button type="submit">Actualizar Producto</button>
    </form>
</body>
</html>
