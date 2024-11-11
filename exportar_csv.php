<?php
include 'conexion.php';

// Definir el nombre del archivo CSV
$filename = "productos.csv";

// Establecer los encabezados para la descarga del archivo
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

// Crear un archivo CSV y agregar el encabezado de las columnas
$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'Nombre', 'Descripción', 'Categoría', 'Proveedor', 'Precio', 'Cantidad', 'Fecha de Ingreso', 'Ubicación', 'Código de Barras', 'Estado'));

// Realizar la consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Verificar si hay resultados y agregarlos al archivo CSV
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

// Cerrar la conexión
$conn->close();
fclose($output);
?>
