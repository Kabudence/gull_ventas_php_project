<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $subcategory = [];
    $subcategory['subcategory_image'] = $_FILES["subcategory_image"]["name"];
    $subcategory['subcategory_nombre'] = $_POST['subcategory_nombre'];
    $subcategory['subcategory_id_categoria'] = $_POST['subcategory_categoria_id'];
    $subcategory['alias'] = $_POST['alias'];//$_POST['alias'];
    $subcategory['statu'] = $_POST['statu'];

    foreach ($subcategory as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {

        if (empty($errors)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, dir_subcategory(), subcategory_post_name());
            $subcategory['image_name'] = $uploaded_msg[0];

            if (insert_subcategory($subcategory) > -1) {
                $success = true;
                $_SESSION['subcategory_msg'] = "SubCategoría agregada con éxito.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'subcategorias.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_subcategoria.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>