<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php';

//Obtener datos del producto
if(isset($_POST['cod'])){ //Pregunta: ¿me han enviado un 'cod'? si es así:
    $codigoProducto = $_POST['cod'];
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE cod = ?"); //Prepara la consulta y la oculta en ?
    $stmt->execute([$codigoProducto]); //Añade el valor preparado en la variable $codigoProducto
    $producto = $stmt->fetch(PDO::FETCH_ASSOC); //En este caso trae una sola fila (no como fetchAll) y la guardae n $producto
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Edición de un producto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edición de un producto</h1>

    <?php if ($producto): ?> <!--Si encuentra el producto muestra el formulario, sino muestra el mensaje de la línea 49-->
        <form method="post" action="actualizar.php"> <!--Al enviar, los datos viajan a actualizar.php-->
            <input type="hidden" name="cod" value="<?= $producto['cod'] ?>"> <!--Guarda el código del producto sin mostrarlo para que actualizar.php sepa cual modificar-->
            <!--Los input y el textarea llevan los datos almacenados en $producto para aparecer ya rellenados, salvo en el caso de 'nombre', 
            que es NULL y debe ser rellenado por el 'required' del HTML-->
            <label for="nombre_corto">Nombre corto:</label>
            <input type="text" id="nombre_corto" name="nombre_corto" value="<?= ($producto['nombre_corto']) ?>" required><br>

            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= ($producto['nombre']) ?>" required><br>

            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" required><?= ($producto['descripcion']) ?></textarea><br>

            <label for="PVP">PVP:</label>
            <input type="text" id="PVP" name="PVP" value="<?= ($producto['PVP']) ?>" required><br>

            <button type="submit" name="accion" value="actualizar">Actualizar</button> <!--Ambos botones tienen el mismo 'name' pero gracias al value distinto actualizar.php sabe qué decidió el usuario-->
            <button type="submit" name="accion" value="cancelar">Cancelar</button>
        </form>
    <?php else: ?>
        <p>Producto no encontrado.</p>
    <?php endif; ?>
</body>
</html>