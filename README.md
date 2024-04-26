<div align="center">
    <h1>¡Me gusta Programar!</h1>  
</div>
<div align="center">
    <a href="https://git.io/typing-svg"><img src="https://readme-typing-svg.demolab.com?font=Roboto+Slab&color=%237E3ACE&size=30&center=true&vCenter=true&width=450&lines=Soy Juan !!;Ingeniero de Sistemas;Backend+Frontend+Dev;Me gusta programar;function+findQuestion(42)" alt="Computer Engineering, Backend front-end developer"></a>
</div>



# Proyecto de Gestión Bancaria

Este proyecto de gestión bancaria está desarrollado con Laravel y Vue.js. Permite la administración de clientes, procesos bancarios y gestión de usuarios.

## Instalación

Sigue estos pasos para instalar y ejecutar el proyecto localmente:

### Requisitos previos

- PHP >= 7.4
- Composer
- Node.js >= 14.x
- NPM o Yarn

### Pasos de instalación

1. Clona el repositorio:
2. 
  ```bash
   git clone https://github.com/juancjaramillo/cuentabancaria.git

```

2. Instala las dependencias PHP con Composer:
   
 ```bash
composer install
```

3. Copia el archivo de configuración .env y configura la base de datos:

 ```bash
cp .env.example .env
```
Edita .env para configurar las credenciales de tu base de datos:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```
4. Genera la clave de aplicación:

```bash
php artisan key:generate
```
5. Ejecuta las migraciones para crear las tablas en la base de datos:

```bash
php artisan migrate:fresh --seed
```
6. Instala las dependencias de frontend con NPM o Yarn:

```bash
npm install
# o
yarn install
```
7. Compila los assets:

```bash
npm run dev
# o
yarn dev
```
8. Inicia el servidor local:

```bash
php artisan serve
```
Accede a http://localhost:8000 en tu navegador para ver la aplicación en funcionamiento.


=======
# cuentabancaria_back
Proyecto que permite crear servicios para consumir en el front
>>>>>>> 01e6293a9127501751dd514b1ff3639490e45ac6
