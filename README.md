# Mi App con Nginx + PHP-FPM + MySQL en Docker

## Descripción
Aplicación PHP desplegada en contenedores usando Docker Compose.

## Servicios
- Nginx (servidor web, puerto 8080)
- PHP-FPM (ejecutor de scripts PHP)
- MySQL (base de datos)

## Instrucciones de despliegue
1. Clonar el repositorio:
   ```bash
   git clone https://github.com/fadegreg/miApp_FdGR
   cd miApp_FdGR
   docker-compose up -d

2. Para acceder a la página es necesario acceder a la URL siguiente:
   ```bash
http://localhost:8080/listado.php