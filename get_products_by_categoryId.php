<?php
require_once 'init.php'; // Incluye la configuración inicial

// Verifica si se proporciona el parámetro 'category_id'
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id']; // Obtiene el ID de la categoría desde la URL

    // Escapa el parámetro para evitar inyecciones SQL
    $category_id = mysqli_real_escape_string($db, $category_id);

    // Consulta SQL para obtener los productos por categoría
    $sql = "SELECT * FROM products WHERE category = '$category_id'";
    $result = mysqli_query($db, $sql);

    if ($result) {
        $products = []; // Array para almacenar los productos

        // Itera los resultados y los agrega al array
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }

        // Libera la memoria del resultado
        mysqli_free_result($result);

        // Devuelve los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode([
            "products" => $products
