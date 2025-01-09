<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {
    $video = [];
    $video['id'] = $_POST['video_id'];
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

    //$video['estado'] = 1;

    /*
      foreach ($video as $key => $value) {
      if (empty($value)) {
      $errors[] = is_empty($key, $value);
      }
      } */
    if (empty($errors)) {
        if (!empty($video['titulo_video_one']) || !empty($video['url_video_one']) ||
                !empty($video['titulo_video_two']) || !empty($video['url_video_two']) ||
                !empty($video['titulo_video_three']) || !empty($video['url_video_three']) ||
                !empty($video['titulo_video_four']) || !empty($video['url_video_four']) ||
                !empty($video['titulo_video_five']) || !empty($video['url_video_five']) ||
                !empty($video['titulo_video_six']) || !empty($video['url_video_six']) ||
                !empty($video['titulo_video_seven']) || !empty($video['url_video_seven']) ||
                !empty($video['titulo_video_eight']) || !empty($video['url_video_eight'])
        ) {
            if (update_video_destacado($video)) {
                $success = true;
                $_SESSION['video_msg'] = "Video actualizado con éxito.";
            }
        } else {
            $errors_mensaje[] = "Debe Registrar al menos un video.";
            $_SESSION['errors'] = $errors_mensaje;
        }

        //$_SESSION['errors'] = $errors;
        if ($success) {
            $redirect_to = root_dir() . 'videos-destacados.php';
            header('Location: ' . $redirect_to);
        } else {
            $redirect_to = root_dir() . 'add_video_destacado.php?video_id=' . $video['id'] . '&&errormsg=true';
            header('Location: ' . $redirect_to);
        }
    }
}
?>