<?php
require_once 'init.php'; // Incluye la configuración inicial

// Array para almacenar los resultados
$response = [
    "tipo_servicio" => []
];

// Consulta para obtener todos los tipos de servicio
$sql_tipo_servicio = "SELECT * FROM tipo_servicio";
$result_tipo_servicio = mysqli_query($db, $sql_tipo_servicio);

if ($result_tipo_servicio) {
    while ($row = mysqli_fetch_assoc($result_tipo_servicio)) {
        $response["tipo_servicio"][] = $row; // Agrega cada tipo de servicio al array de respuesta
    }
    mysqli_free_result($result_tipo_servicio);
} else {
    $response["error"] = "Error al obtener tipo_servicio: " . mysqli_error($db);
}

// Establece el encabezado para JSON y envía la respuesta
header('Content-Type: application/json');
echo json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
?>
