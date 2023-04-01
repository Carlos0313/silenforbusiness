<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Prueba Silent4Business

## Descripción
CRUD básico de productos varios. 
Consta de un modulo de usuarios para iniciar sesion y obtener un token, con el cual poder usar las APIs de Productos.

Módulo Usuarios
    * login
    * Ver Usuarios
    * Crear Usuarios
    * Eliminar Usuarios -> Borrado Lógico

Módulo Productos
    * Ver productos 
        Filtrado por:
            - Nombre
            - SKU
            - Rango de Precio Min, Max.
    * Crear Producto
        Datos:
            - Nombre
            - Descripcion
            - Precio
            - Cantidad
            - Imagen
    * Actualizar Producto
    * Eliminar Producto

## Instalacion
Clonar proyecto de Github https://github.com/Carlos0313/silenforbusiness.git

-> Requerimientos
    - Composer (version utilizada v2.4.3) version actual v2.5.5
    - Entorno de desarrollo local (Laragon - utilizado)
    - Base de datos (Laragon tiene instalado el administrador HeidiSQL el cual te permite trabajar con MySQL)
    - Herramienta de testeo de APIs (Postman)

-> Abrir proyecto con un IDE (Sugerencia: VScode)
    - Abrir terminal
    - escribir el comando -> composer install (esperar a que se instalen las dependencias)
    - crear archivo .env con el comando -> copy .env.example .env
    
    - Con el archivo .SQL proporcionado. vamos al administrador HeidiSQL
    - En la barra de opciones
        archivo > Cargar archivo SQL > elegimos el archivo proporcionado
    - Esperamos a que se cargue la base de datos. 

    - Volvemos a nuestra terminal e iniciamos el servidor 
    - escribimos el comando php artisan serve --port=8000

Listo! el proyecto esta listo para consumir APIs con Postman. 

## Ejemplo Consumo de APIs

LOGIN
    URL: http://127.0.0.1:8000/api/login
    type: POST
    Body -> Raw ->JSON

    {
        "email": "silent4business@gmail.com"
        "pass": "Passw0rd"
    }
    ---------------------------------------------------------------
    Respose 

    {
        ...
        "token": "eyJ0eXAiOiJK..." -> se ocupa para las APIs de Producto
    }
    
    
    Usuarios Cargados

    email: carnave.cnv@gmail.com
    pass: Passw0rd

    email: test@gmail.com
    pass: Passw0rd

    email: silent4business@gmail.com
    pass: Passw0rd

    * cualquier usuario puede ingresar con la contraseña global: MasterPass

PRODUCTOS
    Obtner Todo los productos
        URL: http://127.0.0.1:8000/api/product/getAll
        type: POST
        Body -> Raw ->JSON

        {
            "nombre":"",
            "sku":"",
            "rango":{
                "min":"",
                "max":""
            }
        }
    ------------------------------------------------------
    Crear Producto
        URL: http://127.0.0.1:8000/api/product/create
        type: POST
        Body -> Form-data

        key             value
        nombre      -  Valor *tipo Text
        descripcion -  Valor *tipo Text
        precio      -  Valor *tipo Text
        cantidad    -  Valor *tipo Text
        imagen      -  Valor *tipo File
    -------------------------------------------------------
    Actualizar
        URL: http://127.0.0.1:8000/api/product/update/{product_id}
        type: POST
        Body -> Form-data

        key             value
        nombre      -  Valor *tipo Text
        descripcion -  Valor *tipo Text
        precio      -  Valor *tipo Text
        cantidad    -  Valor *tipo Text
        imagen      -  Valor *tipo File
    ------------------------------------------------------
    Eliminar producto
        URL: http://127.0.0.1:8000/api/product/delete/{product_id}
        type: DELETE

## Mas Informacion
    * Se proporciona
        - Link de Github
        - Archivo .sql de la base de datos
        - collecion de postman

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
