# laravel7-api

## Api Rest con Laravel 7 y Sanctum

La documentación del proyecto esta pendiente pero puedes comenzar a utilizar esta aplicación

## Instalacion

Clona o descargar el repositorio en tu ordenador e instala las dependencias dentro de la carpeta 
del proyecto.

```
    composer install
```

Una vez instaladas las dependencias crea en tu sistemas una base de datos llamada laravel7 o modifica
el archivo .env y cambia el nombre de la base de datos.

Luego corre las migraciones.

```
    php artisan migrate
```

Por último inicia el servidor de pruebas y comienza a probar la aplicación.

```
    php artisan serve
```

## Los endpoints

Existen 4 endpoints dentro de la aplicacion 3 para la autenticación (registro, login y logout) y un
endpoint para controlar los productos de la DB (un solo endpoint para las 4 acciones de crud) es un 
resource endpoint, si no estas familiarizado con ellos te recomiendo que leas [resource-controller](https://laravel.com/docs/7.x/controllers#resource-controllers)

Si quieres ver los endpoins completos puedes ejecutar en una consola el comando:

```
    php artisan route:list
```

### Register endpoint

Este es el endpoint para registrarse su url si estas probando en local será localhost:80008/api/register.
Deberas ejecutar la petición desde tu [postman](www.postman.com) con el método post y json con los siguientes datos.

```javascript
    {
        "nombre":"ejemplo",
        "email":"ejemplo@contacto.org",
        "password":"hola123",
        "password_confirmation":"hola123"
    }
```

Al enviar la petición recibiras un json con tu usuario y tu token de autenticación.

### Login endpoint

Este es el endpoint para iniciar sesión cuando ya estras registrado, su url es localhost:8000/api/login.
Deberas ejecutar la petición con el método post y un json con los siguientes datos.

```javascript
    {
        "nombre":"ejemplo",
        "password":"hola123"
    }
```

Al enviar la peticion recibiras un json con tu usuario y un token de autenticación.

### Logout endpoint

Este es el endpoint para cerrar sesión. Su url es localhost:8000/api/logout.
Deberas ejecutar la petición con el método post y un json con los siguientes datos.

```javascript
    {
        "id":4
    }
```

Ademas de enviar como autorizacion el token que se te ha entregado al iniciar session, deberas anexarlo como un 
bearer token. Esto eliminará todos los token relacionados con el usuario en cuestión.