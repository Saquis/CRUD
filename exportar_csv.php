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

// Realizar la consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Verificar si la consulta se ejecuta correctamente y tiene filas
if ($result && $result->num_rows > 0) {
    // Recorrer cada fila y escribirla en el archivo CSV
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, array(
            $row['id'],
            $row['nombre'],
            $row['descripcion'],
            $row['categoria'],
            $row['proveedor'],
            $row['precio'],
            $row['cantidad'],
            $row['fecha_ingreso'],
            $row['ubicacion'],
            $row['codigo_barras'],
            $row['estado']
        ));
    }
} else {
    // En caso de no haber resultados, escribir un mensaje de "sin datos"
    fputcsv($output, array("Sin datos disponibles o error en la consulta"));
}

// Cerrar la conexión y el archivo de salida
$conn->close();
fclose($output);
exit();
