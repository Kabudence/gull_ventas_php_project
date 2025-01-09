<?php

ini_set('display_errors', 1);
require_once('init.php');

$errors = [];
$success = false;


$admin_info = logged_in();
if ($admin_info) {
    list($admin_id, $username) = $admin_info;
}

$product = [
    'titulo' => $_POST['titulo'] ?? null,
    'categoria' => $_POST['categoria'] ?? null
];

if (empty($product['titulo'])) {
    $errors[] = is_empty("Título", $product['titulo']);
}

if (empty($product['categoria'])) {
    $errors[] = is_empty("Categoría", $product['categoria']);
}

$uploadDir = "../public/uploads/publicaciones/";
$params = [
    'id' => $_POST['publicacion_id'] ?? null,
    'titulo' => $_POST['titulo'] ?? null,
    'estado' => $_POST['estado'] ?? null,
    'categoria' => $_POST['categoria'] ?? null,
    //'imagen' => $_FILES['imagen']['name'] ?? null,

    'resumen' => $_POST['resumen'] ?? null,
    'link_video' => $_POST['link_video'] ?? null,

    'subtitulo1' => $_POST['subtitulo1'] ?? null,
    'descripcion1' => $_POST['description1'] ?? null,
    'tipo_adjunto1_1' => $_POST['tipo_adjunto1_1'] ?? null,
    'adjunto1_1_video' => $_POST['adjunto1_1_video'] ?? null,
    'tipo_adjunto1_2' => $_POST['tipo_adjunto1_2'] ?? null,
    'adjunto1_2_video' => $_POST['adjunto1_2_video'] ?? null,
    //'adjunto1_1_imagen' => $_FILES['adjunto1_1_imagen']['name'] ?? null,
    //'adjunto1_2_imagen' => $_FILES['adjunto1_2_imagen']['name'] ?? null,

    'subtitulo2' => $_POST['subtitulo2'] ?? null,
    'descripcion2' => $_POST['description2'] ?? null,
    'tipo_adjunto2_1' => $_POST['tipo_adjunto2_1'] ?? null,
    'adjunto2_1_video' => $_POST['adjunto2_1_video'] ?? null,
    'tipo_adjunto2_2' => $_POST['tipo_adjunto2_2'] ?? null,
    'adjunto2_2_video' => $_POST['adjunto2_2_video'] ?? null,
    //'adjunto2_1_imagen' => $_FILES['adjunto2_1_imagen']['name'] ?? null,
    //'adjunto2_2_imagen' => $_FILES['adjunto2_2_imagen']['name'] ?? null

    'subtitulo3' => $_POST['subtitulo3'] ?? null,
    'descripcion3' => $_POST['description3'] ?? null,
    'tipo_adjunto3_1' => $_POST['tipo_adjunto3_1'] ?? null,
    'adjunto3_1_video' => $_POST['adjunto3_1_video'] ?? null,
    'tipo_adjunto3_2' => $_POST['tipo_adjunto3_2'] ?? null,
    'adjunto3_2_video' => $_POST['adjunto3_2_video'] ?? null,

    'tipo_seccion' => $_POST['tipo_seccion'] ?? null,
];

$paramsURLGET = http_build_query(array_filter($params));

function handle_image_upload($file_key, $uploadDir)
{
    if (!empty($_FILES[$file_key]['name'])) {
        $file_info = pathinfo($_FILES[$file_key]['name']);
        $unique_image_id = md5(uniqid());
        $image_path = $uploadDir . $unique_image_id . '.' . $file_info['extension'];
        if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $image_path)) {
            return $unique_image_id . '.' . $file_info['extension'];
        }
        return "Error al subir la imagen.";
    }
    return null;
}

if (empty($errors)) {
    foreach ([
        'imagen',
        'adjunto1_1_imagen', 'adjunto1_2_imagen',
        'adjunto2_1_imagen', 'adjunto2_2_imagen',
        'adjunto3_1_imagen', 'adjunto3_2_imagen'
    ] as $file) {
        $result = handle_image_upload($file, $uploadDir);
        if ($result && strpos($result, 'Error') === false) {
            $params[$file] = $result;
        } elseif (strpos($result, 'Error') !== false) {
            $errors[] = $result;
        }
    }

    //$params['current_date'] = date('Y-m-d');
    //$params['tipo_seccion'] = 'publicacion';
    if (update_publicacion($params) > -1) {
        $success = true;
        $_SESSION['product_msg'] = "Publicación añadida con éxito.";
    } else {
        $errors[] = "Error al insertar la publicación";
    }
}

$_SESSION['errors'] = $errors;
if ($success) {
    if ($params['tipo_seccion'] == 'publicacion') {
        $redirect_to = root_dir() . 'publicaciones.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'videos.php';
        header('Location: ' . $redirect_to);
    }
} else {

    if ($params['tipo_seccion'] == 'publicacion') {
        $redirect_to = root_dir() . 'add_publicacion.php?product_id=' . $product['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_video.php?product_id=' . $product['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
