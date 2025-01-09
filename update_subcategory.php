<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];

if (!empty($_POST)) {

    $subcategory = [];
    $subcategory_image = $_FILES["subcategory_image"]["name"];
    $subcategory['subcategory_id'] = $_POST['subcategory_id'];
    $subcategory['subcategory_id_categoria'] = $_POST['subcategory_categoria_id'];
    $subcategory['subcategory_nombre'] = $_POST['subcategory_nombre'];
    $subcategory['image_name'] = $_POST['subcategory_img_name'];
    
    $subcategory['alias'] = $_POST['alias']; //$_POST['alias'];
    $subcategory['statu'] = $_POST['statu'];

    foreach ($subcategory as $key => $value) {
        if (empty($value)) {
            if ($key == 'image_name')
                continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (empty($errors)) {

        if (!empty($category_image)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_subcategory(), subcategory_post_name());
            delete_image($subcategory['image_name'], dir_subcategory());

            $subcategory['image_name'] = $uploaded_msg[0];
        }

        if (update_subcategory($subcategory)) {
            $success = true;
            $_SESSION['product_msg'] = "Subcategoria actualizada con éxito.";
        }
    }


    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'subcategorias.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_subcategoria.php?subcategory_id=' . $subcategory['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>