<?php

require_once('init.php');

$errors = [];
$errors_mensaje = [];
$success = false;

if (!empty($_POST)) {
    $video = [];
    $video['user_id'] = $_POST['admin_id'];

    $video['titulo_video_one'] = $_POST['titulo'];
    $video['url_video_one'] = $_POST['link_video'];

    $video['titulo_video_two'] = $_POST['titulo02'];
    $video['url_video_two'] = $_POST['link_video_02'];

    $video['titulo_video_three'] = $_POST['titulo03'];
    $video['url_video_three'] = $_POST['link_video_03'];

    $video['titulo_video_four'] = $_POST['titulo04'];
    $video['url_video_four'] = $_POST['link_video_04'];

    $video['titulo_video_five'] = $_POST['titulo05'];
    $video['url_video_five'] = $_POST['link_video_05'];

    $video['titulo_video_six'] = $_POST['titulo06'];
    $video['url_video_six'] = $_POST['link_video_06'];

    $video['titulo_video_seven'] = $_POST['titulo07'];
    $video['url_video_seven'] = $_POST['link_video_07'];

    $video['titulo_video_eight'] = $_POST['titulo08'];
    $video['url_video_eight'] = $_POST['link_video_08'];


    $video['statu'] = 1;


    /* foreach ($video as $key => $value) {
      if (empty($value))
      $errors[] = is_empty($key, $value);
      } */
    if (empty($errors)) {
        if (empty($errors)) {
            $user_id = $_POST['admin_id'];
            $row = get_registers_video_destacado($user_id);
            $number_videos = $row['valor'];
            if ($number_videos >= 1) {
                $errors_mensaje[] = "La aplicación solo permite un registro con 8 videos máximo por tienda.";
                $_SESSION['errors_limit'] = $errors_mensaje;
            } else {
                if (!empty($video['titulo_video_one']) || !empty($video['url_video_one']) ||
                        !empty($video['titulo_video_two']) || !empty($video['url_video_two']) ||
                        !empty($video['titulo_video_three']) || !empty($video['url_video_three']) ||
                        !empty($video['titulo_video_four']) || !empty($video['url_video_four']) ||
                        !empty($video['titulo_video_five']) || !empty($video['url_video_five']) ||
                        !empty($video['titulo_video_six']) || !empty($video['url_video_six']) ||
                        !empty($video['titulo_video_seven']) || !empty($video['url_video_seven']) ||
                        !empty($video['titulo_video_eight']) || !empty($video['url_video_eight'])
                ) {
                    if (insertar_video_destacados($video) > -1) {
                        $success = true;
                        $_SESSION['video_msg'] = "Video agregado con éxito.";
                    }
                } else {
                    $errors_mensaje[] = "Debe Registrar al menos un video.";
                    $_SESSION['errors'] = $errors_mensaje;
                }
            }
        }
    }

    //$_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'videos-destacados.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir() . 'add_video_destacado.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>