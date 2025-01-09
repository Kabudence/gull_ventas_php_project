<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];

if(!empty($_POST)){
	
	$slider = [];
	$slider_image =  $_FILES["slider_image"]["name"];

	$slider['sort'] = 2;
	$slider['id'] = $_POST['slider_id'];
	$slider['image_name'] = $_POST['slider_img_name'];
	$slider['statu'] = $_POST['statu'];
        $slider['title'] = $_POST['title'];
	
	foreach($slider as $key => $value) {
		if(empty($value)){
			if($key == 'image_name') continue;
			$errors[] = is_empty($key, $value);
		}
	}
	
	if(empty($errors)){
		
		if (!empty($slider_image)) {
			$file_name_no_ext = md5(uniqid(rand(), true));
			$uploaded_msg = upload_img($file_name_no_ext, dir_slider(), slider_post_name());
			//delete_image($slider['image_name'], "../public/uploads/recent-products/");
                        delete_image($slider['image_name'], dir_slider());			
			$slider['image_name'] = $uploaded_msg[0];			
		}
			//$slider['title'] = $_POST['title'];
			
		if(update_slider($slider)){
			$success = true;
			$_SESSION['product_msg'] = "Slider actualizada con éxito.";
		}
	}
	
	
	$_SESSION['errors'] = $errors;
	
	if($success){ 
		$redirect_to = root_dir() . 'slider.php';
		header('Location: ' . $redirect_to); 
	}else{
		$redirect_to = root_dir().'add_slider.php?slider_id='. $slider['id'] .'&&errormsg=true';
		header('Location: ' . $redirect_to); 
	}
	
}
	

?>