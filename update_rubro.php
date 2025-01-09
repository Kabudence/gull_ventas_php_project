<?php

require_once('init.php');

$errors = [];
$success = false;
//$product = [];

if(!empty($_POST)){
	
	$rubro = [];
	$rubro['id'] = $_POST['rubro_id'];
	$rubro['descripcion'] = $_POST['descripcion'];
	$rubro['codigo'] = $_POST['codigo'];
	$rubro['statu'] = $_POST['statu'];
	
	foreach($rubro as $key => $value) {
		if(empty($value)){
			$errors[] = is_empty($key, $value);
		}
	}
	
	if(empty($errors)){
		
		if(update_rubro($rubro)){ 
			$success = true;
			$_SESSION['rubro_msg'] = "Rubro actualizado con éxito.";
		}
	}
	
	
	$_SESSION['errors'] = $errors;	
	if($success){ 
		$redirect_to = root_dir() . 'rubros.php';
		header('Location: ' . $redirect_to); 
	}else{
		$redirect_to = root_dir().'add_rubro.php?rubro_id='. $rubro['id'] .'&&errormsg=true';
		header('Location: ' . $redirect_to); 
	}	
}

?>