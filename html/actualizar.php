<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

$mensaje = ''; //El texto comienza como un mensaje vacío para inicializar la variable
if($_SERVER['REQUEST_METHOD'] == 'POST'){ //Comprueba que se llegó aquí a través de un formulario (y no escribiendo una dirección a mano)
    if($_POST['accion']=='actualizar'){
        //Actualizar datos del producto
        //Esto permite actualizar todos los campos con lo que aporta el formulario, primero lo prepara
        $stmt = $pdo->prepare("UPDATE producto SET nombre_corto = ?, nombre = ?, descripcion = ?, PVP = ? WHERE cod = ?"); //Ya preparado lo ejecuta
        $stmt->execute([$_POST['nombre_corto'], $_POST['nombre'], $_POST['descripcion'], $_POST['PVP'], $_POST['cod']]); //y así rellena los campos
        $mensaje = "Se han actualizado los datos.";
    } else {
        $mensaje = "Actualización cancelada."; //Si no se eligió 'Actualizar' en editar.php debería haberse elegido 'Cancelar' por lo que muestra el mensaje
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualización de producto</title>
</head>
<body>
    <h1>Actualización de producto</h1>
    <p><?= $mensaje ?></p> <!--Esto permite mostrar el $mensaje definido en el if de más arriba-->
    <form method="get" action="listado.php"> <!--Como es un get te lleva de vuelta a listado.php y así carga la página sin la opcion elegida-->
        <button type="submit">Continuar</button>
    </form>
</body>
</html>