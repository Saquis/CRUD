<?php
include 'conexion.php'; // Incluye la conexión a la base de datos

// Limpiar el buffer de salida
if (ob_get_level()) {
    ob_end_clean();
}

// Configurar las cabeceras para forzar la descarga del archivo CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="productos.csv"');

// Abrir php://output como el "archivo" para escribir el CSV
$output = fopen('php://output', 'w');

// Escribir la primera fila con los encabezados de las columnas en el CSV
fputcsv($output, array('ID', 'Nombre', 'Descripción', 'Categoría', 'Proveedor', 'Precio', 'Cantidad', 'Fecha de Ingreso', 'Ubicación', 'Código de Barras', 'Estado'));

// Solo escribe un dato fijo para comprobar si la conexión a la base afecta la salida
fputcsv($output, array(1, 'Producto de prueba', 'Descripción de prueba', 'Categoría', 'Proveedor', 10.0, 5, '2024-01-01', 'Ubicación', '123456789', 'Disponible'));

// Cerrar la conexión y el archivo de salida
$conn->close();
fclose($output);
exit();
