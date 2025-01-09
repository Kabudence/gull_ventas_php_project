<?php

require_once 'init.php'; // Incluye la configuración inicial

// Array para almacenar los resultados
$response = [
    "products" => []
];

// Consulta para obtener todos los productos
$sql_products = "SELECT * FROM products";
$result_products = mysqli_query($db, $sql_products);

if ($result_products) {
    while ($row = mysqli_fetch_assoc($result_products)) {
        $response["products"][] = $row; // Agrega cada producto al array de respuesta
    }
    mysqli_free_result($result_products);
} else {
    $response["error"] = "Error al obtener productos: " . mysqli_error($db);
}

// Establece el encabezado para JSON y envía la respuesta
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

