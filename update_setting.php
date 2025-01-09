<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {
    $ssetting_id = $_POST['setting_id'];

    $setting = [];
    $new_panel_logo = $_FILES["site_logo"]["name"];
    $setting['panel_tag_line'] = $_POST['site_tag'];
    $setting['panel_site_name'] = $_POST['site_title'];
    $setting['setting_id'] = $_POST['setting_id'];
    $setting['panel_logo_name'] = $_POST['site_logo_prev'];
    $setting['panel_currency'] = $_POST['site_currency'];
    $setting['politicas'] = $_POST['politicas'];
    $setting['admin_id'] = $_POST['admin_id'];
//$setting['panel_currency'] = '$';

    foreach ($setting as $key => $value) {
        if (empty($value)) {
            if ($key == 'site_logo')
                continue;
            $errors[] = is_empty($key, $value);
        }
    }

    if (!empty($errors)) {
        if (!empty($new_panel_logo)) {
            $file_name_no_ext = md5(uniqid(rand(), true));
            $uploaded_msg = upload_img($file_name_no_ext, '../public/uploads/user-images/', 'site_logo');

            delete_image($setting['panel_logo_name'], '../public/uploads/user-images/');

            $setting['panel_logo_name'] = $uploaded_msg[0];
        }


        if (!empty($ssetting_id)) {

            if (update_setting_by_id($setting)) {
                $success = true;
                $_SESSION['setting_msg'] = "Configuración actualizada correctamente.";
                $redirect_to = '../public/settings.php';
                header('Location: ' . $redirect_to);
            }
            $_SESSION['errors'] = $errors;
        } else {
            if (insert_setting($setting)) {
                $success = true;
                $_SESSION['setting_msg'] = "Configuración actualizada correctamente.";
                $redirect_to = '../public/settings.php';
                header('Location: ' . $redirect_to);
            }
        }

    }

    $_SESSION['errors'] = $errors;

}
?>