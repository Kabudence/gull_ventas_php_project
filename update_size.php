<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];

if (!empty($_POST)) {

    $product_size = [];
// 	$product_size['size_id'] = $_POST['size_id'];
// 	$product_size['size_name'] = $_POST['size_name'];
    $product_size['category'] = $_POST['category'];
    $product_size['rubro_id'] = $_POST['size_id'];

//    echo "rubro_id_update" . $_POST['size_id'];
    // Tallas.
    $arr_tag = $_POST['tag'];
    $arr_id_producto_size = $_POST['id_product_size'];
//    $arr_id_producto_name = $_POST['id_product_size_name'];

    $i = 0;
//    $$product_size_ids = [];
//    $cod_product_size = "";

    foreach ($arr_tag as $talla) {
        //echo $talla . $arr_id_producto_size[$i];

        if (!empty($arr_id_producto_size[$i])) {
            //update_size($product_size, $arr_id_producto_size[$i], trim(strtoupper($talla)));
//            delete_product_size_by_id($arr_id_producto_size[$i]);
            delete_product_size_by_id($arr_id_producto_size[$i]);
            insert_size_for_product_size_tam($arr_id_producto_size[$i], $product_size, trim(strtoupper($talla)));

//            if (!empty($talla)) {
//                insert_size_for_product_size_tam($arr_id_producto_size[$i], $product_size, trim(strtoupper($talla)));
//            }

            $success = true;
            $_SESSION['product_size_msg'] = "Tamaño actualizado con éxito.";
        }

        if (empty($arr_id_producto_size[$i])) {
            insert_size_for_catego($product_size, trim(strtoupper($talla)));
            $success = true;
            $_SESSION['product_size_msg'] = "Tamaño actualizado con éxito.";
        }

        $i++;
    }
    $_SESSION['errors'] = $errors;

    if ($success) {
        $redirect_to = root_dir() . 'tamano_sizes.php';
        header('Location: ' . $redirect_to);
    } else {
        //$redirect_to = root_dir() . 'add_tamano_size.php?size_id=' . $product_size['size_id'] . '&&errormsg=true';
        $redirect_to = root_dir() . 'add_tamano_size.php?errormsg=true';
        header('Location: ' . $redirect_to);
    }

//    foreach ($arr_id_producto_size as $key => $tam_id) {
//        if (!empty($arr_tag[$key])) {
    //echo $tam_id . "=" . trim($arr_tag[$key]);
//              update_size($product_size,$tam_id, trim(strtoupper($arr_tag[$key])));
//        }
//        
//         if (empty($arr_tag[$key])) {
//            echo $tam_id . "=" . trim($arr_tag[$key]);
//        }
//        if (update_size($product_size,$tam_id,$arr_id_producto_name[$key])) {
//            //$success = true;
//            //$_SESSION['product_size_msg'] = "Tamaño actualizado con éxito.";
//        }
//        echo $key . "=" . $tam_id;
//        foreach ($arr_id_producto_name as  $key => $tam_name_id ){
//             echo $tam_id . "=" . $arr_id_producto_name[$key];
//             echo "update set id= ' ".$tam_id. " ' , nombre = ' ".$arr_id_producto_name[$key]. " ";
//        }
//        $cod_product_size = $tam_id;
    //echo $tam_id;
//         echo $i++;
//        foreach ($arr_id_producto_size as $tam_size_name) {
////            echo "update set id= ' ".$tam_id. " ' , nombre = ' ".$tam_size_name. " ";
//        }
    //echo $tam_id;
    //echo "update set id= ' ".$tam_id. " ' , nombre = ' ".$tam_id. " ";
    //echo $i++;
//    }
//	foreach($product_size as $key => $value) {
//		if(empty($value)){
//			$errors[] = is_empty($key, $value);
//		}
//	}
    // Testing category
//	var_dump($errors);
//	exit();
    // Recorrer cada tag
//	foreach ($arr_tag as $talla) {
//	     echo $talla;
//	    if(empty($errors)){
//          	if(update_size($product_size, $talla)){
//    			$success = true;
//    			$_SESSION['product_size_msg'] = "Tamaño actualizado con éxito.";
//    		}
//	    }
//	}
//	$_SESSION['errors'] = $errors;
//	
//	if($success){ 
//		$redirect_to = root_dir() . 'tamano_sizes.php';
//		header('Location: ' . $redirect_to); 
//	}else{
//		$redirect_to = root_dir().'add_tamano_size.php?size_id='. $product_size['size_id'] .'&&errormsg=true';
//		header('Location: ' . $redirect_to); 
//	}
}
?>