<?php

require_once('init.php');

$errors = [];
$success = false;

if(!empty($_POST)){
	
	$dieta = [];
	$dieta['id'] = $_POST['dieta_id'];
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

	foreach($dieta as $key => $value) {
		if(empty($value)){
			$errors[] = is_empty($key, $value);
		}
	}
	
	if(empty($errors)){
		
		if(update_dieta($dieta)){ 
			$success = true;
			$_SESSION['dieta_msg'] = "Dieta actualizado con éxito.";
		}
	}
	
	$_SESSION['errors'] = $errors;	
	if($success){ 
		$redirect_to = root_dir() . 'dietas.php';
		header('Location: ' . $redirect_to); 
	}else{
		$redirect_to = root_dir().'add_dieta.php?dieta_id='. $dieta['id'] .'&&errormsg=true';
		header('Location: ' . $redirect_to); 
	}	
}

?>