<?php

require_once('init.php');

	
$errors = [];
$success = false;

if(!empty($_POST)){
	
	$email = $_POST['email'];
	$password = $_POST['password'];

	if(empty($email)) $errors[] = is_empty("Email", $email);
	if(empty($password)) $errors[] = is_empty("Password", $password);

	if(empty($errors)){
	//+	if(invalid_email("Email", $email)) $errors[] = invalid_email("Email", $email) ;
		if(invalid_length("Password", $password, 3)) $errors[] = invalid_length("Password", $password, 3) ;
		$admin = admin_login($email, $password);;
		
		if(!empty($admin)){
			$success = true;

			$_SESSION['admin_id'] = $admin['user_id'];
			$_SESSION['username'] = $admin['username'];
			$_SESSION['fullname'] = $admin['first_name']." ".$admin['last_name'];
			$_SESSION['grobaltype'] = $admin['type'];
			$_SESSION['globaltypeservice'] = $admin['cod_tipo_servicio'];

		}else $errors[] ="Teléfono o contraseña no válidos";
	}
	
	$_SESSION['errors'] = $errors;

	if($success){ 
		$redirect_to = root_dir() . 'index.php';
		header('Location: ' . $redirect_to); 
	}else{
		$redirect_to = root_dir().'admin-login.php?errormsg=true';
		header('Location: ' . $redirect_to); 
	}
}
	

?>