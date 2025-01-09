<?php

require_once('init.php');

$errors = [];
$success = false;

if (!empty($_POST)) {

    $rol = [];
    
    $rol['nombre'] = $_POST['nombre'];
    $rol['permiso'] = $_POST['permiso'];
    $rol['statu'] = $_POST['statu'];
    $rol['id'] = $_POST['rol_id'];
   
    $tipo = $_POST['cod_tipo_servicio'];
   
    //Catalogo
    if ($tipo == 1) {
        $rol['chkcatalogo'] = $_POST['chkcatalogo'];
        $rol['chkprod'] = $_POST['chkprod'];
        $rol['chkslider'] = $_POST['chkslider'];
        $rol['chkpolitica'] = $_POST['chkpolitica'];
    }
    //Carro de compra
    if ($tipo == 2) {
        if (empty($_POST['chkcarro'])) {
            echo $rol['carro_compras'] = 0;
        } else {
            echo $rol['carro_compras'] = 1;
        }
        
        if (empty($_POST['chkplancarro'])) {
            echo $rol['planes'] = 0;
        } else {
            echo $rol['planes'] = 1;
        }
        
        if (empty($_POST['chkdescuentoscarro'])) {
            echo $rol['descuentos'] = 0;
        } else {
            echo $rol['descuentos'] = 1;
        }
        
        if (empty($_POST['chkestrategiacarro'])) {
            echo $rol['estrategia'] = 0;
        } else {
            echo $rol['estrategia'] = 1;
        }
        
        if (empty($_POST['chkventascarro'])) {
            echo $rol['ventas'] = 0;
        } else {
            echo $rol['ventas'] = 1;
        }
        
        if (empty($_POST['chkprodcarro'])) {
            echo $rol['productos_destacados'] = 0;
        } else {
            echo $rol['productos_destacados'] = 1;
        }
        
        if (empty($_POST['chkslidercarro'])) {
            echo $rol['slider'] = 0;
        } else {
            echo $rol['slider'] = 1;
        }
        
        if (empty($_POST['chkpoliticarro'])) {
            echo $rol['politicas'] = 0;
        } else {
            echo $rol['politicas'] = 1;
        }        
    }

    if (empty($errors)) {
        if (empty($errors)) {
            //$usuario_inserted_id = insert_usuario($usuario);
            if (update_rol_permisos($rol)) {                
                $success = true;
                $_SESSION['rol_msg'] = "Rol actualizado con exito.";
            }
        }
    }
    $_SESSION['errors'] = $errors;
    if ($success) {
        $redirect_to = root_dir() . 'roles.php';
        header('Location: ' . $redirect_to);
    } else {
        $redirect_to = root_dir().'add_rol.php?rol_id='. $rol['id'] .'&&errormsg=true';
        header('Location: ' . $redirect_to);
    }
}
?>