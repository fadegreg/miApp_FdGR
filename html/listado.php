<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'db.php'; 

/*Con esto importamos la base de datos del archivo que la contiene, 
cuyas instrucciones ya hemos definido en el docker en docker-compose.yml*/

//Obtener familias: pide todas las filas de la tabla familia y las guarda en $familias como una lista de filas. FETCH_ASSOC significa que cada fila se accede por nombre de columna ($familia['nombre']).
$familias = $pdo->query("SELECT * FROM familia")->fetchAll(PDO::FETCH_ASSOC);

//Manejar selección de familia
$productos = []; //Empieza con una lista vacía (por si acaso aun no se ha elegido nada)
if(isset($_POST['familia'])){ //Comprueba si han mandado una 'familia' desde el formualario y si es así hace lo siguiente
    $familiaSeleccionada = $_POST['familia']; //Guarda los datos en $familiaSeleccionada
    $stmt = $pdo->prepare("SELECT * FROM producto WHERE familia = ?"); //Prepara la consulta y la oculta con ?
    $stmt->execute([$familiaSeleccionada]); //Rellena el hueco con el valor, evitando así la inyección SQL
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC); //Guarda todos los productos encontrados en la variable $productos
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de productos de una familia</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Listado de productos de una familia</h1>
    <form method="post" action="listado.php"> <!-- Al enviarse, la página se llama a sí misma con la familia elegida-->
        <label for="familia">Seleccione una familia:</label>
        <select name="familia" id="familia">
            <?php foreach ($familias as $familia): ?> <!--Crea un <option> por cada familia. El value es el 'cod' y lo visible es el nombre. Con 'selected' deja marcada la familia que acabas de elegir-->
                <option value="<?= $familia['cod'] ?>" <?= isset($familiaSeleccionada) && $familiaSeleccionada == $familia['cod'] ? 'selected' : '' ?>><?= htmlspecialchars($familia['nombre']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Mostrar productos</button>
    </form>

    <?php if (!empty($productos)): ?> <!--Solo mostrará el listado si hay productos en la lista-->
        <h2>Productos de la familia</h2>
        <ul>
            <?php foreach ($productos as $producto):?> 
                <!--Este foreach crea un <li> por producto usando 'nombre corto' y 'precio' y un pequeño formulario que lleva oculto (hidden) el campo 
                    que contiene el 'cod' del producto para llegar a editar.php. Por eso cada producto tiene su propio botón Editar-->
                <li>
                    <?= htmlspecialchars($producto['nombre_corto']) ?> - <?= htmlspecialchars($producto['PVP']) ?>€
                    <form method="post" action="editar.php" style="display:inline">
                        <input type="hidden" name="cod" value="<?= $producto['cod'] ?>">
                        <button type="submit">Editar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>
</html>

