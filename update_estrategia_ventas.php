<?php

require_once('init.php');

$errors = [];
$success = false;
$product = [];
$id_imagen = $_POST['id_imagen'];


if (!empty($_POST)) {

    $product = [];
    $estrategia_horario_image = $_FILES["horario_image"]["name"];
    $estrategia_profesor_image = $_FILES["profesor_image"]["name"];

    $product['id'] = $_POST['estrategia_id'];
    $product['title'] = $_POST['title'];
    $product['statu'] = $_POST['statu'];
    $product['category'] = $_POST['category'];
    $product['tipo_producto'] = $_POST['tipo_producto'];

    $product['description'] = $_POST['description'];
    $product['price'] = $_POST['price']; //price normal
    $product['price_oferta'] = $_POST['price_oferta']; //price plan
    $product['id_product_dos_uno'] = $_POST['lstproductosdosuno'];

    //$product['descuento'] = $_POST['descuento'];
    $product['tipo_producto'] = $_POST['tipo_producto'];
    $product['qty'] = $_POST['qty'];
    //$product['inicio'] = $_POST['inicio'];
    //$product['fin'] = $_POST['fin'];

    $product['promocion'] = $_POST['promo'];
    $product['horario'] = $_POST['horario'];
    $product['profesor'] = $_POST['profesor'];

    $product['horario_image'] = $_POST['estrategia_img_horario'];
    $product['profesor_image'] = $_POST['estrategia_img_profesor'];

    if (isset($_POST['tam'])) {
        $product['id_product_size'] = $_POST['tam'];
    } else {
        $product['id_product_size'] = 0;
    }

    if (isset($_POST['price_paquete'])) {
        $product['price_paquete'] = $_POST['price_paquete'];
    } else {
        $product['price_paquete'] = '0';
    }

    if (isset($_POST['tipo_promocion'])) {
        $product['tipo_promocion'] = $_POST['tipo_promocion'];
    } else {
        $product['tipo_promocion'] = 0;
    }
//cortesia
    if (isset($_POST['lstproductos'])) {
        $product['id_product_images'] = $_POST['lstproductos'];
    } else {
        $product['id_product_images'] = 0;
    }
//mitad precio
    if (isset($_POST['lstproductosmitad'])) {
        $product['id_product_mitad_precio'] = $_POST['lstproductosmitad'];
    } else {
        $product['id_product_mitad_precio'] = 0;
    }
// dos x uno
    if (isset($_POST['lstproductosdosuno'])) {
        $product['id_product_dos_uno'] = $_POST['lstproductosdosuno'];
    } else {
        $product['id_product_dos_uno'] = 0;
    }

    if (isset($_POST['promo'])) {
        $product['promocion'] = $_POST['promo'];
    } else {
        $product['promocion'] = 2;
    }

    if (isset($_POST['price_paquete'])) {
        $product['price_paquete'] = $_POST['price_paquete'];
    } else {
        $product['price_paquete'] = 0;
    }

    if (isset($_POST['price_oferta'])) {
        $product['price_oferta'] = $_POST['price_oferta'];
    } else {
        $product['price_oferta'] = 0;
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

    //$product['id_product_size'] = $_POST['tam'];
    // Script para ACTUALIZAR foto talla
    // portadas
    //$uploads_portadas = '../public/uploads/fotos-tallas/';
    $name_porta = "";
    $query_file = "";

    if (empty($product['precio_plan']))
        $product['precio_plan'] = 0;

    if (empty($product['price_paquete']))
        $product['price_paquete'] = 0;

    if (empty($product['precio_normal']))
        $product['precio_normal'] = 0;

    if (empty($product['price_oferta']))
        $product['price_oferta'] = 0;

    if (empty($product['tipo_producto']))
        $product['tipo_producto'] = 0;

    if (empty($product['id_product_images']))
        $product['id_product_images'] = 0;

    if (empty($product['id_product_mitad_precio']))
        $product['id_product_mitad_precio'] = 0;

    if (empty($product['lstproductosdosuno']))
        $product['lstproductosdosuno'] = 0;

    if (empty($product['promocion']))
        $product['promocion'] = 2;

    $product_image = $_FILES["file"]["name"];
    $product_images = [];

    if (empty($errors)) {
        if (!is_numeric($product['price'])) {
            $errors[] = invalid_price_msg("Price");
        }
        if (empty($errors)) {
            if (!empty($product_image)) {
                $j = 0;     // Variable for indexing uploaded image.
                // Declaring Path for uploaded images.
                for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
                    $target_path = "../public/uploads/estrategias/";
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
                
            }

            if (!empty($product_image)) {

                // delete_image($product['image_name'], dir_recent_product());
                $product['image_name'] = $product_images[0]['name_img'];
                $product_inserted_id = $_POST['estrategia_id']; //insert_product($product);
                //$product_inserted_id = $_POST['descuento_id'];
                //$product_inserted_id = $product['id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['estrategia_id'] = $product_inserted_id;
                        if (update_estrategia_images($images) > -1) {
                            $_SESSION['product_msg'] = "Producto actualizado con éxito.";
                        }
                    }
                    $success = true;
                    $_SESSION['product_msg'] = "Producto actualizado con éxito.";
                }
            } else {
                $product_inserted_id = $_POST['estrategia_id']; //insert_product($product);

                if ($product_inserted_id > -1) {

                    foreach ($product_images as $image) {
                        $images['image_name'] = $image['name_img'];
                        $images['id_imagen'] = $image['id_imagen'];
                        $images['estrategia_id'] = $product_inserted_id;
                        if (update_estrategia_images($images) > -1) {
                            $_SESSION['product_msg'] = "Producto actualizado con éxito.";
                        }
                    }
                    $success = true;
                    $_SESSION['product_msg'] = "Producto actualizado con éxito.";
                }
            }

            /* if (!empty($estrategia_horario_image)) {
              $file_name_no_ext = md5(uniqid(rand(), true));
              $uploaded_msg = upload_img($file_name_no_ext, dir_horario(), estrategia_horario_post_name());
              delete_image($product['horario_image'], dir_horario());
              $product['horario_image'] = $uploaded_msg[0];
              } */


            if ($estrategia_horario_image != "" || $estrategia_horario_image != null) {
                if (!empty($estrategia_horario_image)) {
                    $file_name_no_ext = md5(uniqid(rand(), true));
                    $uploaded_msg = upload_img($file_name_no_ext, dir_horario(), estrategia_horario_post_name());
                    delete_image($product['horario_image'], dir_horario());
                    $product['horario_image'] = $uploaded_msg[0];
                }
            }

            if ($estrategia_profesor_image != "" || $estrategia_profesor_image != null) {
                if (!empty($estrategia_profesor_image)) {
                    $file_name_no_ext_two = md5(uniqid(rand(), true));
                    $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_profesor(), estrategia_profesor_post_name());
                    delete_image($product['profesor_image'], dir_profesor());
                    $product['profesor_image'] = $uploaded_msg_two[0];
                }
            }

            /* if (!empty($estrategia_profesor_image)) {
              $file_name_no_ext_two = md5(uniqid(rand(), true));
              $uploaded_msg_two = upload_img($file_name_no_ext_two, dir_profesor(), estrategia_profesor_post_name());
              delete_image($product['profesor_image'], dir_profesor());
              $product['profesor_image'] = $uploaded_msg_two[0];
              } */

            if (update_estrategia_venta($product)) {
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
        $redirect_to = root_dir() . 'estrategia_ventas.php';
        header('Location: ' . $redirect_to);
    } else {
        //$redirect_to = root_dir().'add_recent_products.php?product_id='. $product['id'] .'&&errormsg=true'.print_r($product_inventory);
        $redirect_to = root_dir() . 'add_estrategia_ventas.php?estrategia_id=' . $product['id'] . '&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>