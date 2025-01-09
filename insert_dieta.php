<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $dieta = [];
    $dieta['user_id'] = $_POST['admin_id'];
    $dieta['tipo_dieta'] = $_POST['tipo_dieta'];
    $dieta['nombre'] = $_POST['nombre'];
    $dieta['dias'] = $_POST['dias'];
    $dieta['duracion'] = $_POST['duracion'];
    $dieta['fecha_inicio'] = $_POST['fecha_inicio'];
    $dieta['fecha_fin'] = $_POST['fecha_fin'];
    $dieta['alumno'] = $_POST['alumno'];
    $dieta['disciplina'] = $_POST['disciplina'];
    $dieta['alergias'] = $_POST['alergias'];
    $dieta['edad'] = $_POST['edad'];
    $dieta['enfermedad_cronica'] = $_POST['enfermedad_cronica'];
    $dieta['alergia_medicamento'] = $_POST['alergia_medicamento'];
    $dieta['statu'] = $_POST['statu'];
    
   /* if (isset($_POST['tipo_dieta'])) {
      $dieta['tipo_dieta'] = $_POST['tipo_dieta'];
    } else {
        $dieta['tipo_dieta'] = "";
    }
   
    if (isset($_POST['nombre'])) {
        $dieta['nombre'] = $_POST['nombre'];
      } else {
          $dieta['nombre'] = "";
      }

      if (isset($_POST['dias'])) {
        $dieta['dias'] = $_POST['dias'];
      } else {
          $dieta['dias'] = "";
      }

      if (isset($_POST['duracion'])) {
        $dieta['duracion'] = $_POST['duracion'];
      } else {
          $dieta['duracion'] = "";
      }

      if (isset($_POST['fecha_inicio'])) {
        $dieta['fecha_inicio'] = $_POST['fecha_inicio'];
      } else {
          $dieta['fecha_inicio'] = "";
      }

      if (isset($_POST['fecha_fin'])) {
        $dieta['fecha_fin'] = $_POST['fecha_fin'];
      } else {
          $dieta['fecha_fin'] = "";
      }

      if (isset($_POST['alumno'])) {
        $dieta['alumno'] = $_POST['alumno'];
      } else {
          $dieta['alumno'] = "";
      }

      if (isset($_POST['disciplina'])) {
        $dieta['disciplina'] = $_POST['disciplina'];
      } else {
          $dieta['disciplina'] = "";
      }

      if (isset($_POST['alergias'])) {
        $dieta['alergias'] = $_POST['alergias'];
      } else {
          $dieta['alergias'] = "";
      }

      if (isset($_POST['disciplina'])) {
        $dieta['disciplina'] = $_POST['disciplina'];
      } else {
          $dieta['disciplina'] = "";
      }

      if (isset($_POST['edad'])) {
        $dieta['edad'] = $_POST['edad'];
      } else {
          $dieta['edad'] = "";
      }

      if (isset($_POST['enfermedad_cronica'])) {
        $dieta['enfermedad_cronica'] = $_POST['enfermedad_cronica'];
      } else {
          $dieta['enfermedad_cronica'] = "";
      }

      if (isset($_POST['alergia_medicamento'])) {
        $dieta['alergia_medicamento'] = $_POST['alergia_medicamento'];
      } else {
          $dieta['alergia_medicamento'] = "";
      }

      if (isset($_POST['statu'])) {
        $dieta['statu'] = $_POST['statu'];
      } else {
          $dieta['statu'] = "";
      }*/

      foreach ($dieta as $key => $value) {
        if (empty($value))
            $errors[] = is_empty($key, $value);
    }

    if (empty($errors)) {
        if (empty($errors)) {
            if (insertar_dieta($dieta) > -1) {                
                $success = true;
                $_SESSION['dieta_msg'] = "Dieta agregado con éxito.";
            }
        }
    }

    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'dietas.php';
        header('Location: ' . $redirect_to);
    } else {

        $redirect_to = root_dir() . 'add_dieta.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>