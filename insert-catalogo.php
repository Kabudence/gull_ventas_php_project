<?php

ini_set('display_errors', 1);
require_once('init.php');

$errors = [];
$success = false;

$admin_info = logged_in();
if (!empty($admin_info)) {
    $admin_id = $admin_info[0];
    $username = $admin_info[1];
}
$parametros = "title=" . $_POST['title'] . "&category=" . $_POST['category'] . "&price=" . $_POST['price'] . "" . "&tipo_producto=" . $_POST['tipo_producto'];
$product = [];
$product['title'] = $_POST['title'];
$product['category'] = $_POST['category'];

/* if (empty($product['category'])) {
  $errors[] = is_empty("Categoría", $product_sizes);
  } */

// Tallas. //ACA PALABRAS CLAVES
//$arr_tag = $_POST['tag'];
$arr_tag = "";

//$palabras_claves = '';
//foreach ($arr_tag as $keyword) {
//    $palabras_claves .= $keyword . ", ";
//}
//$product['palabras_claves'] = substr($palabras_claves, 0, strlen($palabras_claves) - 2);
// var_dump($product);
// exit();

$product['price'] = $_POST['price'];
$product['porcentaje'] = $_POST['descuento'];
//$product['price'] = ceil($precio_vender);
$product['fecha_registro'] = date('Y-m-d');
$product['user_id'] = $admin_id;
//$product['fecha_inicio'] = $_POST['inicio'];
//$product['fecha_fin'] = $_POST['fin'];
$product['description'] = $_POST['description'];
$product['statu'] = $_POST['statu'];
$product['tipo_producto'] = $_POST['tipo_producto'];
$product['promocion'] = $_POST['promo'];
$product['qty'] = $_POST['qty'];
$product['statu'] = $_POST['statu'];
$product['previous_price'] = $_POST['price_previous'];

$product['marca'] = $_POST['marca'];

$product['link_video_one'] = $_POST['link_video_one'];
$product['link_video_two'] = $_POST['link_video_two'];


if (isset($_POST['marca'])) {
    $product['marca'] = $_POST['marca'];
} else {
    $product['marca'] = "";
}

if (isset($_POST['link_video_one'])) {
    $product['link_video_one'] = $_POST['link_video_one'];
} else {
    $product['link_video_one'] = "";
}

if (isset($_POST['link_video_two'])) {
    $product['link_video_two'] = $_POST['link_video_two'];
} else {
    $product['link_video_two'] = "";
}

if (isset($_POST['tam'])) {
    $product['id_product_size'] = $_POST['tam'];
} else {
    $product['id_product_size'] = 0;
}

if (isset($_POST['price_previous'])) {
    $product['price_previous'] = $_POST['price_previous'];
} else {
    $product['price_previous'] = 0;
}

if (isset($_POST['inicio'])) {
    $product['fecha_inicio'] = $_POST['inicio'];
} else {
    $product['fecha_inicio'] = "";
}

if (isset($_POST['fin'])) {
    $product['fecha_fin'] = $_POST['fin'];
} else {
    $product['fecha_fin'] = "";
}

$name_porta = "";

/* if (empty($product['price']))
  $product['price'] = 0; */

if (empty($product['tipo_producto']))
    $product['tipo_producto'] = 0;

if (empty($product['id_product_size']))
    $product['id_product_size'] = 0;

$contador_imagenes = 1;

$product_images = [];
if (empty($errors)) {
    if (!is_numeric($product['price'])) {
        $errors[] = invalid_price_msg("Precio");
        //$errors[] = invalid_price_msg("Price");
    }

    if (empty($errors)) {

        $j = 0;     // Variable for indexing uploaded image.
        // Declaring Path for uploaded images.
        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
         //if(count($_FILES['file']['name'])>=3){   
            //$contador_imagenes++;
            
            if ($_FILES['file']['name'][$i] != null) {
                $target_path = "../public/uploads/catalogos/";
                echo "ruta " . $target_path;

                // Loop to get individual element from the array
                $validextensions = array("jpeg", "jpg", "png", "JPG");      // Extensions which are allowed.
                $ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
                $file_extension = end($ext); // Store extensions in the variable.
                $unique_image_ext = $ext[count($ext) - 1];
                $unique_image_id = md5(uniqid());

                $target_path = $target_path . $unique_image_id . '.' . $unique_image_ext;     // Set the target path with a new name of image.
                $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
                ///list($width, $height, $type, $attr) = getimagesize($file);
                /* echo "Ancho: " .$width;
                  echo "Alto: " .$height;
                  echo "Tipo: " .$type;
                  echo "Atributos: " .$attr; */

                /* $file=fopen($file,"w+"); 
                  fwrite ($file,$buffer); */

                if (($_FILES["file"]["size"][$i] < 50000000)     // Approx. 500kb files can be uploaded. 50000000
                        && in_array($file_extension, $validextensions)
                ) {
                    if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
                        $file = $target_path;  // Dirección de la imagen  
                        chmod($file, 0777);
                        $target_path = "";
                        //$datos_imagen = ['name_img' => $unique_image_id . '.' . $unique_image_ext,
                        //  'color_id' => $_POST['color_img'][$i]];

                        $datos_imagen = ['name_img' => $unique_image_id . '.' . $unique_image_ext,
                            ""];

                        array_push($product_images, $datos_imagen);
                        echo $j . ').<span id="noerror">Imagen cargada con éxito !.</span><br/><br/>';
                    } else {
                        echo $j . ').<span id="error">¡Inténtalo de nuevo!.</span><br/><br/>';
                    }
                } else {
                    $errors[] = "Max Image size 500kb";
                    echo $j . ').<span id="error">*** Tamaño o tipo de archivo no válido ***</span><br/><br/>';
                }

                $imagen = getimagesize($file);    //Sacamos la información
                $ancho = $imagen[0];              //Ancho
                $alto = $imagen[1];
                // if (( $ancho <=500) && ( $alto <=400)) {
                // }else{
                // $errors[] = "El tamaño de la imagen debe ser máximo 400x500";
                // echo $j . ').<span id="error">*** ¡Inténtalo de nuevo subiendo otra imagen!. ***</span><br/><br/>';
                // }
            }
             $_SESSION['errors'] = "Debe cargar por cuatro imagenes ";
        }
        
        }
        if (empty($errors)) {
            $product["image_name"] = $product_images[0]['name_img'];
            if (empty($product["image_name"])) {
                  $_SESSION['errors'] = "Debe cargar por lo menos una imagen.... ";        
            } else {
                //Instructor / Horario
//                if (empty($errors)) {
//                    $file_name_no_ext = md5(uniqid(rand(), true));
//                    $uploaded_msg = upload_img($file_name_no_ext, dir_horario(), plan_horario_post_name());
//                    $product['horario_image'] = $uploaded_msg[0];
//
//                    $file_name_no_ext_two = md5(uniqid(rand(), true));
//                    $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_profesor(), plan_profesor_post_name());
//                    $product['profesor_image'] = $uploaded_msg_two[0];
//                }

                echo $product_inserted_id = insertar_catalogo($product);
                echo "<br> des";
                //   if($medidasX!=="" || $medidasY!=="" || $medidasZ!==""){
                //      insert_sizes_product($product_inserted_id, $sizes, $medidasX, $medidasY, $medidasZ);  
                //   }
                echo "<br> des2";

                if ($product_inserted_id > -1) {
                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        $images['catalogo_id'] = $product_inserted_id;
                        if (insert_catalog_images($images) > -1) {
                            $_SESSION['product_msg'] = "Catalogo añadido con éxito.";
                        }
                    }
                    echo "<br> des3";
                    $success = true;
                    $_SESSION['product_msg'] = "Catalogo añadido con éxito.";
                }
            }
        }
    }
//}

$_SESSION['errors'] = $errors;
if ($success) {
    //$redirect_to = root_dir() . 'add_product_stock.php?produc_id=' . $product_inserted_id;
    $redirect_to = root_dir() . 'catalogos.php';
    header('Location: ' . $redirect_to);
} else {
    $redirect_to = root_dir() . 'add_catalogo.php?errormsg=true&' . $parametros;
    header('Location: ' . $redirect_to);
}
echo "fin";
//}
