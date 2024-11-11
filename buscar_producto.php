<?php
include 'conexion.php';

header('Content-Type: application/json'); // Asegurar que la respuesta sea JSON

try {
    // Verificar si se recibió el término de búsqueda
    if (isset($_GET['termino'])) {
        $termino = trim($_GET['termino']); // Limpiar espacios adicionales
        $termino = '%' . $termino . '%'; // Añadir comodines para la búsqueda

        // Depuración: Imprimir el término que se está utilizando para la búsqueda
        error_log("Término de búsqueda: " . $termino); 

        // Preparar la consulta SQL
        $sql = "SELECT * FROM productos WHERE nombre LIKE ? OR descripcion LIKE ? OR categoria LIKE ? OR proveedor LIKE ?";
        $stmt = $conn->prepare($sql);

        // Verificar si la preparación de la consulta fue exitosa
        if ($stmt === false) {
            echo json_encode(["error" => "Error en la preparación de la consulta: " . $conn->error]);
            exit();
        }
        
        $stmt->bind_param("ssss", $termino, $termino, $termino, $termino);
        $stmt->execute();
        $result = $stmt->get_result();

        $productos = [];
        while ($row = $result->fetch_assoc()) {
            $productos[] = $row;
        }

        // Depuración: Contar los productos encontrados
        error_log("Número de productos encontrados: " . count($productos));

        // Cerrar la declaración
        $stmt->close();

        // Verificar si se encontraron productos y devolver los resultados
        if (empty($productos)) {
            echo json_encode(["message" => "No se encontraron productos para el término proporcionado: " . htmlspecialchars($_GET['termino'])]);
        } else {
            echo json_encode($productos);
        }
    } else {
        // Devolver un mensaje de error si el término de búsqueda no está definido
        echo json_encode(["error" => "Término de búsqueda no proporcionado."]);
    }
} catch (Exception $e) {
    // Capturar cualquier excepción y devolverla en formato JSON
    echo json_encode(["error" => "Ocurrió un error: " . $e->getMessage()]);
} finally {
    // Cerrar la conexión en el bloque finally para asegurar que siempre se ejecute
    if ($conn && !$conn->connect_error) {
        $conn->close();
    }
}
exit(); // Asegurar que no haya ninguna salida adicional
?>
