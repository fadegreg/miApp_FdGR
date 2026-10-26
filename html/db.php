<?php
//Esta página no se visita nunca directamente sino que los otros php lo importan con 'include db.php'
//Este php abre la conexión con MySQL y deja listo un objeto llamado $pdo que los demás archivos usan para hacer consultas

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Extracción segura mediante variables de entorno (Docker-ready)
//getenv lee las variables de entorno que se definieron en el docker-compose.yml permitiendo que no haya que escribir usuario y contraseña dentro del código
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$dsn  = "mysql:host=$host;dbname=$dbname;charset=utf8mb4"; //Esta es la "dirección" de la base de datos


try { //Intenta conectar, si falla muestra el mensaje de error del catch
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //A pesar de la dirección especificada mas arriba el 'new PDO' construye su propia cadena
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Ordena que si una consulta falla, PHP lance un mensaje de error en lugar de fallar en silencio (que es lo que hace si no lo indicas)
}catch (PDOException $e){
    echo "Error en la conexión: " . $e->getMessage();
}
?>