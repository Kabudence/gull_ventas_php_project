<?php

require_once('init.php');

$errors = [];
$success = false;

if(!empty($_POST)){
	
	$restriccion = [];
	$restriccion['id'] = $_POST['restriccion_id'];
	$restriccion['id_negocio'] = $_POST['tienda'];
	$restriccion['limite_producto'] = $_POST['limiteproductos'];
	$restriccion['limite_foto'] = $_POST['limitefotos'];
		
	foreach($restriccion as $key => $value) {
		if(empty($value)){
			$errors[] = is_empty($key, $value);
		}
	}
	
	if(empty($errors)){
		
		if(update_restriccion($restriccion)){ 
			$success = true;
			$_SESSION['restriccion_msg'] = "Restriccion actualizado con éxito.";
		}
	}	
	
	$_SESSION['errors'] = $errors;	
	if($success){ 
		$redirect_to = root_dir() . 'restricciones.php';
		header('Location: ' . $redirect_to); 
	}else{
		$redirect_to = root_dir().'add_restriccion.php?restriccion_id='. $restriccion['id'] .'&&errormsg=true';
		header('Location: ' . $redirect_to); 
	}	
}

?>