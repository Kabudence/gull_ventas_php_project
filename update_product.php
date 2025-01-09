<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];
$id_imagen = $_POST['id_imagen'];
$producto_horario_image = $_FILES["horario_image"]["name"];
$producto_profesor_image = $_FILES["profesor_image"]["name"];

if (!empty($_POST)) {
    $comision = 0;
    $nuevo_precio = 0;
//    $traer_comision = traer_comision_activa();
//    foreach ($traer_comision as $comi) {
//        $id = $comi['id_comision'];
//        $tipo = $comi['tipo'];
//        $cantidad = $comi['cantidad'];
//        if ($id == 1) {
//            $comision = ($cantidad / 100) * $_POST['price'];
//            $nuevo_precio = $_POST['price'] + $comision;
//            $comi_pasarela = 0.05 * $nuevo_precio;
//            $igv_pasarela = 0.18 * $comi_pasarela;
//            $precio_vender = $nuevo_precio + $comi_pasarela + $igv_pasarela;
//        } else {
//            $comision = $cantidad;
//            $nuevo_precio = $_POST['price'] + $comision;
//            $comi_pasarela = 0.05 * $nuevo_precio;
//            $igv_pasarela = 0.18 * $comi_pasarela;
//            $precio_vender = $nuevo_precio + $comi_pasarela + $igv_pasarela;
//        }
//    }

    $product = [];
    $product['title'] = $_POST['title'];
    $product['category'] = $_POST['category'];
    $product['description'] = $_POST['description'];
    //$product['price'] = ceil($precio_vender);
    $product['price'] = $_POST['price'];
    // $product['purchase_price'] = $_POST['purchase_price'];
    // $product['previous_price'] = $_POST['previous_price']; 
    $product['purchase_price'] = $_POST['price'];
    $product['previous_price'] = $_POST['price_previous'];
    $product['date'] = '2017-2-2';
    $product['sort'] = 2;
    $product['id'] = $_POST['product_id'];

    //$product['weight'] = $_POST['weight'];
    $product['weight'] = "";
    //$product['longs'] = $_POST['longs'];
    $product['longs'] = "";
    //$product['long_sleeve'] = $_POST['long_sleeve'];
    $product['long_sleeve'] = "";
    //$product['back_width'] = $_POST['back_width'];
    $product['back_width'] = "";
    //$product['breast_contour'] = $_POST['breast_contour'];
    $product['breast_contour'] = "";
    $product['waist'] = $_POST['waist'];
    $product['hip'] = $_POST['hip'];
    $product['statu'] = $_POST['statu'];

    $product['descuento'] = $_POST['descuento'];
    $product['tipo_producto'] = $_POST['tipo_producto'];
    $product['qty'] = $_POST['qty'];
    $product['inicio'] = $_POST['inicio'];
    $product['fin'] = $_POST['fin'];
    $product['id_product_size'] = $_POST['tam'];
    $product['promocion'] = $_POST['promo'];

    $product['horario'] = $_POST['horario'];
    $product['profesor'] = $_POST['profesor'];

    $product['horario_image'] = $_POST['producto_img_horario'];
    $product['profesor_image'] = $_POST['proucto_img_profesor'];

    if (isset($_POST['tam'])) {
        $product['id_product_size'] = $_POST['tam'];
    } else {
        $product['id_product_size'] = 0;
    }

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


    //$product['brand'] = $_POST['brand'];
    $product['brand'] = "";

    // Script para ACTUALIZAR foto talla
    // portadas
    $uploads_portadas = '../public/uploads/fotos-tallas/';
    $name_porta = "";
    $query_file = "";


// ========= valida si subio imagen y video ======
    /* if (is_uploaded_file($_FILES['fotos_talla']['tmp_name'])) {
      // get image info
      $menu_image = $_FILES['fotos_talla']['name'];
      $image_error = $_FILES['fotos_talla']['error'];
      $image_type = $_FILES['fotos_talla']['type'];

      // common image file extensions
      $allowedExts = array("gif", "jpeg", "jpg", "png");

      // Get extesion imagen
      $extension = end(explode(".", $_FILES["fotos_talla"]["name"]));
      $name_prim = current(explode(".", $_FILES["fotos_talla"]["name"]));

      // create random imagen file name
      // $string = '0123456789';
      // $file = preg_replace("/\s+/", "_", $_FILES['foto']['name']);
      // $function = new functions;
      // $name_porta = $function->get_random_string($string, 4)."-".date("Y-m-d"). "." . $extension;
      $name_porta = $name_prim . "-" . date("Y-m-d") . "." . $extension;


      // upload new audio to server
      $upload = move_uploaded_file($_FILES['fotos_talla']['tmp_name'], "$uploads_portadas/$name_porta");

      // concateno si subio
      //++ $query_file .= ", url_portada='$name_porta'";
      }

      $name_porta = "";
      $product['fotos_talla'] = $name_porta; */

    // ================

    $product_image = $_FILES["file"]["name"];
    $product_images = [];


//  echo print_r($product_inventory);
    /*    foreach ($product as $key => $value) {
      if (empty($value)) {
      if ($key == 'previous_price' || $key == 'image_name') continue;
      $errors[] = is_empty($key, $value);
      }
      }
     */

    if (empty($errors)) {

        if (!is_numeric($product['price']) || !is_numeric($product['previous_price'])) {
            $errors[] = invalid_price_msg("Price");
        }

        if (empty($errors)) {

            if (!empty($product_image)) {

                $j = 0;     // Variable for indexing uploaded image.
                // Declaring Path for uploaded images.
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $target_path = "../public/uploads/recent-products/";

                    // Loop to get individual element from the array
                    $validextensions = array("jpeg", "jpg", "png", "JPG");      // Extensions which are allowed.
                    $ext = explode('.', basename($_FILES['file']['name'][$i]));   // Explode file name from dot(.)
                    $file_extension = end($ext); // Store extensions in the variable.
                    $unique_image_ext = $ext[count($ext) - 1];
                    $unique_image_id = md5(uniqid());

                    $target_path = $target_path . $unique_image_id . '.' . $unique_image_ext;     // Set the target path with a new name of image.
                    $j = $j + 1;      // Increment the number of uploaded images according to the files in array.
                    if (($_FILES["file"]["size"][$i] < 50000000)     // Approx. 500kb files can be uploaded.
                            && in_array($file_extension, $validextensions)
                    ) {
                        if (move_uploaded_file($_FILES['file']['tmp_name'][$i], $target_path)) {
                            $target_path = "";
                            $datos_imagen = ['name_img' => $unique_image_id . '.' . $unique_image_ext,
                                'color_id' => $_POST['color_img'][$i],
                                'id_imagen' => $id_imagen[$i]];
                            array_push($product_images, $datos_imagen);
                            echo $j . ').<span id="noerror">Imagen cargada con éxito !.</span><br/><br/>';
                        } else {
                            echo $j . ').<span id="error">¡Inténtalo de nuevo!.</span><br/><br/>';
                        }
                    } else {
                        echo $j . ').<span id="error">*** Tamaño o tipo de archivo no válido ***</span><br/><br/>';
                    }
                }
            } else {

                //for ($a = 0; $a < count($_POST['color_img']); $a++) {

                /* for ($a = 0; $a < 4; $a++) {
                  $datos_imagen = ['name_img' => "",
                  //'color_id' => $_POST['color_img'][$a],
                  'color_id' =>$id_imagen[$a],
                  'id_imagen' => $id_imagen[$a]];
                  array_push($product_images, $datos_imagen);
                  } */
                //array_push($product_images, $datos_imagen);
            }

            if (!empty($product_image)) {

                // delete_image($product['image_name'], dir_recent_product());
                $product['image_name'] = $product_images[0]['name_img'];
                $product_inserted_id = $_POST['product_id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        $images['id_color'] = $image['color_id'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['product_id'] = $product_inserted_id;
                        if (update_product_images($images) > -1) {
                            $_SESSION['product_msg'] = "Producto añadido con éxito.";
                        }
                    }

                    $success = true;
                    $_SESSION['product_msg'] = "Producto añadido con éxito.";
                }
            } else {
                $product_inserted_id = $_POST['product_id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        $images['id_color'] = $image['color_id'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['product_id'] = $product_inserted_id;
                        if (update_product_images($images) > -1) {
                            $_SESSION['product_msg'] = "Producto añadido con éxito.";
                        }
                    }


                    $success = true;
                    $_SESSION['product_msg'] = "Producto añadido con éxito.";
                }
            }

            //$producto_horario_image = $_FILES["horario_image"]["name"];
            //$producto_profesor_image = $_FILES["profesor_image"]["name"];


            if ($producto_horario_image != "" || $producto_horario_image != null) {
                if (!empty($producto_horario_image)) {
                    $file_name_no_ext = md5(uniqid(rand(), true));
                    $uploaded_msg = upload_img($file_name_no_ext, dir_horario(), plan_horario_post_name());
                    delete_image($product['horario_image'], dir_horario());
                    $product['horario_image'] = $uploaded_msg[0];
                }
            }

            //$product['horario_image'] = $uploaded_msg[0];
            //$product['horario_image'] = $_POST['producto_img_horario'];

            if ($producto_profesor_image != "" || $producto_profesor_image != null) {
                if (!empty($producto_profesor_image)) {
                    $file_name_no_ext_two = md5(uniqid(rand(), true));
                    $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_profesor(), plan_profesor_post_name());
                    delete_image($product['profesor_image'], dir_profesor());
                    $product['profesor_image'] = $uploaded_msg_two[0];
                }
            }
            //$product['profesor_image'] = $uploaded_msg_two[0];
            //$product['profesor_image'] = $_POST['proucto_img_profesor'];

            if (update_product($product)) {
                $success = true;

                $_SESSION['product_msg'] = "Producto actualizado con éxito.";
            } else {
                $success = false;
            }
        }
    }


    $_SESSION['errors'] = $errors;

    echo print_r($product_images);

    if ($success) {
        //$redirect_to = root_dir() . 'update_produc_stock.php?product_id='.$product_inserted_id;
        $redirect_to = root_dir() . 'recent_products.php';
        header('Location: ' . $redirect_to);
    } else {
        //$redirect_to = root_dir().'add_recent_products.php?product_id='. $product['id'] .'&&errormsg=true'.print_r($product_inventory);
        $redirect_to = root_dir() . 'add_recent_products.php?product_id=' . $product['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>