# BackBone Zip Codes
El proyecto tiene como objetivo recibir un código postal y devolver los asentamientos, municipios y estados asociados.

## Abordaje del Problema
En primer lugar, se descargaron los datos en formato xlsx a fin de analizar su composición, las entidades identificables y sus relaciones.

Una vez generadas y ejecutadas las migraciones, se decidieron generar los scripts de poblado de datos. Para ello se utilizaron dos métodos. 
* Cuando la cantidad de registros permitía generar de manera sencilla las sentencias en los archivos php, se utilizaron los métodos de Eloquent. 


* Por otro lado, cuando la cantidad de registros dificultaba la generación de las sentencias, se procedió a importarlas a la base de datos local y obtener las sentencias DML, las cuales luego fueron incorporadas a los archivos php para su ejecución con el método db:seed.

Una vez generadas y pobladas las tablas, se creó el endpoint en el archivo api.php y se invocó la llamada a un controlador creado para resolver la consulta. El método del controlador, se fue refinando de manera iterativa para devolver el formato de respuesta deseado.

### Verificaciones Realizadas
Se incorporó el manejo de Códigos Postales Inexistentes, **tantos Numéricos como Alfanuméricos**


## Estructura del Proyecto
El proyecto se encuentra en una estructura de directorios pensada para la utilización de Docker, tanto al momento del desarrollo como para su despliegue.

### Stack Utilizado
* Servidor Web: Apache y PHP 8 de la imagen de Docker php:8-apache (por defecto)
* Composer
* [Laravel 9](https://laravel.com/docs/9.x/)

Base de Datos: [MySQL 8.0](https://www.mysql.com/)

### Requerimientos
* Docker / [Docker Desktop](https://www.docker.com/products/docker-desktop)

### Deploy de Proyecto
El proyecto se encuentra pensado para poder generar imágenes de distribución mediante la utilización de docker-compose-dist y los Dockerfile-dist de cada una de las carpetas.

Las diferencias fundamentales con los archivos del ambiente de desarrollo, radican en
que los archivos fuentes se copian al contenedor en lugar de crear un montaje.
Por otro lado, se ejecutan comandos de caché, tanto de rutas como de configuraciones en las versiones
distribuibles.

`docker-compose up -d -f docker-compose-dist --build`

### Estructura de Archivos

* `/database` contiene el docker file de MySQL.
* `/web-server` contiene el docker file de PHP.
* `/web-server/config` contiene los archivos de configuración de apache y php. Estos archivos se copian al contenedor al momento de generarlos. Si se modifican, será necesario regenerar los contenedores.
* `/web-server/www/` carpeta para los archivos Laravel del proyecto.

## Instalar el ambiente de desarrollo
### Configurar el ambiente de desarrollo
A continuación, se explica brevemente la configuración a realizar en el archivo .env de la carpeta raíz:

* `COMPOSE_PROJECT_NAME`: El nombre del stack de contenedores que se generarán.

* `WEB_WERVER_NAME`: El nombre que le daremos al contenedor del servidor web

* `PHP_VERSION` versión de PHP ([Versiones disponibles de PHP](https://github.com/docker-library/docs/blob/master/php/README.md#supported-tags-and-respective-dockerfile-links)).

* `DB_SERVER_NAME`: El nombre que tendrá el contenedor del Mysql

* `MYSQL_DATABASE`: El Nombre de la Base de Datos a Crear.

Adicionalmente, se pueden modificar otros parámetros, como ser:
* `PHP_PORT` puerto a mapear para servidor web.
* `MYSQL_VERSION` versión de MySQL([Versiones disponibles de MySQL](https://hub.docker.com/_/mysql)).
* `MYSQL_USER` nombre de usuario para conectarse a MySQL.
* `MYSQL_PASSWORD` clave de acceso para conectarse a MySQL.

### Levantar los contenedores
Ingresar a la carpeta docker y ejecutar desde la línea de comandos:
`docker-compose up -d --build`. 
Alternativamente, se puede ejecutar el archivo **build.sh**

### Configurar el .env
* Copiar el archivo www/.env.example a un archivo /www/.env.
* Configurar el archivo .env. Al menos las opciones APP_ y DB_.
* Como nos encontramos dentro del stack de docker, en DB_HOST se puede ingresar el _nombre del contenedor y el puerto real_ (no el publicado en el servidor).
  Ej:
  `DB_CONNECTION=mysql`
  `DB_HOST=db`
  `DB_PORT=3306`
  `DB_DATABASE=laravel`
  `DB_USERNAME=user`
  `DB_PASSWORD=1234`

### Ejecutar Comandos desde el contenedor.
Una vez instalado y levantado los contenedores, ingresar al contenedor y ejecutar los siguientes comandos:
* `composer install`: Descarga las dependencias de la carpeta vendor que no forman parte del repositorio
* `php artisan key:generate`: Genera la App Key en el .env
* `php artisan storage:link`: Genera el Link Simbólico
* `php artisan migrate`: Crea las Tablas Básicas del Sistema

### Permisos
Si se ejecutaron los comandos desde la consola del contenedor, es probable que tengamos problemas de permisos. Otorgar acceso al _www-data_

Desde el terminal de la máquina ejecutar:
* `sudo chown [owner]:www-data storage -R`
* `sudo chmod 775 storage -R`


