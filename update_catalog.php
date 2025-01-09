<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];
$id_imagen = $_POST['id_imagen'];

if (!empty($_POST)) {
    $comision = 0;
    $nuevo_precio = 0;

    $product = [];
    $product['title'] = $_POST['title'];
    $product['category'] = $_POST['category'];
    $product['description'] = $_POST['description'];
    //$product['price'] = ceil($precio_vender);
    $product['price'] = $_POST['price'];
    //$product['previous_price'] = $_POST['price_previous'];
    $product['id'] = $_POST['catalog_id'];
    $product['statu'] = $_POST['statu'];
    $product['descuento'] = $_POST['descuento'];
    $product['tipo_producto'] = $_POST['tipo_producto'];
    $product['qty'] = $_POST['qty'];
    $product['inicio'] = $_POST['inicio'];
    $product['fin'] = $_POST['fin'];
    $product['id_product_size'] = $_POST['tam'];
    $product['promocion'] = $_POST['promo'];

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

    // Script para ACTUALIZAR foto talla
    // portadas
    //$uploads_portadas = '../public/uploads/fotos-tallas/';
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
        if (!is_numeric($product['price'])) {
            $errors[] = invalid_price_msg("Price");
        }
        if (empty($errors)) {
            if (!empty($product_image)) {
                $j = 0;     // Variable for indexing uploaded image.
                // Declaring Path for uploaded images.
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $target_path = "../public/uploads/catalogos/";

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
                                //'color_id' => $_POST['color_img'][$i],
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
                $product_inserted_id = $_POST['catalog_id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        //$images['id_color'] = $image['color_id'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['catalog_id'] = $product_inserted_id;
                        if (update_catalog_images($images) > -1) {
                            $_SESSION['product_msg'] = "Catalogo actualizado con éxito.";
                        }
                    }
                    $success = true;
                    $_SESSION['product_msg'] = "Catalogo actualizado con éxito.";
                }
            } else {
                $product_inserted_id = $_POST['catalog_id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        //$images['id_color'] = $image['color_id'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['product_id'] = $product_inserted_id;
                        if (update_catalog_images($images) > -1) {
                            $_SESSION['product_msg'] = "Catalogo añadido con éxito.";
                        }
                    }


                    $success = true;
                    $_SESSION['product_msg'] = "Catalogo añadido con éxito.";
                }
            }

            if (update_catalog($product)) {
                $success = true;
                $_SESSION['product_msg'] = "Catalogo actualizado con éxito.";
            } else {
                $success = false;
            }
        }
    }


    $_SESSION['errors'] = $errors;

    echo print_r($product_images);

    if ($success) {
        //$redirect_to = root_dir() . 'update_produc_stock.php?product_id='.$product_inserted_id;
        $redirect_to = root_dir() . 'catalogos.php';
        header('Location: ' . $redirect_to);
    } else {
        //$redirect_to = root_dir().'add_recent_products.php?product_id='. $product['id'] .'&&errormsg=true'.print_r($product_inventory);
        $redirect_to = root_dir() . 'add_catalogo.php?catalogo_id=' . $product['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>