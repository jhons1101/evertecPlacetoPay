# PlaceToPay Evertec
### Features

- Laravel 8, Eloquent ORM, Bootstrap 5, MySQL;
&nbsp;
&nbsp;
![](https://static.placetopay.com/placetopay-logo.svg)
&nbsp;
&nbsp;
- Aplicativo para prueba de ingreso a la empresa Evertec, el cual consiste en un sistema PHP Laravel 8 para consumo de los servicios RestFul Con WebCheckOut, en donde se obtiene una URL a la cual será redireccionado tu usuario para realizar el proceso transaccional en la pasarela de pagos.
&nbsp;
-El API de WebCheckOut está basado en REST, retorna respuestas con codificación JSON
&nbsp;

**Table of Contents**

[TOCM]

[TOC]

#Despliegue
- Una vez se clone el proyecto en su maquina local, se debe de copiar el contenido del archivo .env.example. En el archivo .env. **En caso de no existir el archivo .env, se deberá crear** y añadirle entonces el contenido del archivo .env.example.
&nbsp; 
- Esto para poder obtener la configuración del proyecto y de las variables de entorno.
&nbsp;
- ***Se debe de crear una base de datos* **en el gestor de MySQL con el nombre '**evertecplacetopay**'. y se debe de revisar el archivo .env, si los datos de coneción a la base de datos corresponde a los valores por defecto. en caso contrario. Se deberá realizar el ajuste en el archivo .env.
&nbsp; 
- En la carpeta del proyecto, se debe de correr el siguiente comando para la descarga e instalación de dependencias.

####Instalación de dependencias
&nbsp; 
`$ composer install`
&nbsp; 
- Se debe entonces ejecutar la migración de la base de datos, por medio del comando.
&nbsp; 
`$ php artisan migrate`
&nbsp; 
- Paso seguido se debe de arrancar el server local mdiante el comando.
&nbsp; 
`$ php artisan serve`
&nbsp; 
- En la URL del server, que debería ser similar o igual a esta.
&nbsp; 
`$ http://127.0.0.1:8000`
&nbsp;
- Podríamos ya ir al navegador en la ruta o URL anterior y desplegar el aplicativo.
&nbsp;
- Pasamos a ejecutar los datos de prueba, el cual llenará la tabla 'products', los cuales podremos visualizar en la pantalla index de nuestro aplicativo. Estos datos podremos usarlos para ejecutar la orden de compra y el pago del producto.
&nbsp;
###Data de pruebas
- Para correr los datos de prueba, ejecutar...
`$ php artisan db:seed --class=ProductSeeder`
&nbsp;.
&nbsp;
##Consideraciones
- Inicialmente el archivo ProductFactory usaba un faker ->currency() para la moneda, pero en vista de que el servicio de PlacetoPay no soporta todas las monedas, se definió 'USD' como moneda fija y estandar.
&nbsp;
&nbsp;
- Para las imagenes de los productos, se usó un faker->imageUrl() para obtener una imagen aleatoria como un placeholder en el desarrollo del aplicativo.
&nbsp;
&nbsp;
&nbsp;

###Imágenes
&nbsp;
![](https://github.com/jhons1101/evertecPlacetoPay/blob/master/public/img/index.png?raw=true)

> Index del aplicativo con productos para generar orden de compra.


![](https://github.com/jhons1101/evertecPlacetoPay/blob/master/public/img/payment.png?raw=true)

> Pasarela de pagos, efectuando la compra, arrojando numero de transación o sesión..

![](https://github.com/jhons1101/evertecPlacetoPay/blob/master/public/img/order-status.png?raw=true)

> Consulta del estado de la orden de compra, por numero de transación o de sesión.

![](https://github.com/jhons1101/evertecPlacetoPay/blob/master/public/img/list-orders.png?raw=true)

> Lista de ordenes de compra con el detalle de la transación.

----
&nbsp;
                    
##Tablas DB
                    
####Orders Table
Nombre columna  | Tipo de dato | Longitud
------------- | -------------
Id  | BIGINT | 20
id_product  | BIGINT | 20
customer_name  | VARCHAR | 80
customer_email  | VARCHAR  | 120
customer_phone  | VARCHAR | 40
status  | ENUM  | 'CREATED','PAYED','REJECTED'
created_at  | TIMESTAMP | 
updated_at  | TIMESTAMP  | 
                    
####Products Table

Nombre columna  | Tipo de dato | Longitud
------------- | -------------
Id  | BIGINT | 20
name  | VARCHAR  | 100
url  | VARCHAR  | 200
currency  | VARCHAR  | 3
cost  | INT  | 11
created_at  | TIMESTAMP | 
updated_at  | TIMESTAMP  | 
