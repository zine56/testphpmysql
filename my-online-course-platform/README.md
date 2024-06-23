# Plataforma de Cursos de Ricardo :D

## Descripción del Proyecto

Este proyecto es una plataforma de cursos en línea donde los usuarios pueden registrarse, iniciar sesión, crear, editar, ver y eliminar cursos. La aplicación está construida utilizando PHP, MySQL y Bootstrap para la interfaz de usuario, y utiliza Docker para facilitar la configuración y despliegue del entorno de desarrollo.

## Instrucciones de Instalación y Configuración

### Prerrequisitos

Asegúrate de tener instalados los siguientes programas en tu máquina:
- Docker
- Docker Compose

### Instalación

1. Clona el repositorio en tu máquina local:

    ```sh
    git clone https://github.com/zine56/testphpmysql
    cd testphpmysql/my-online-course-platform
    ```

2. Ejecuta el docker-compose:

    ```sh
    docker-compose up --build
    ```

    Esto descargará las imágenes de Docker necesarias, construirá los contenedores y ejecutará la aplicación.
    ATENCIÓN: aun cuando aparezcan como todos los contenedores inicializados, puede que se demore unos segundos en cargar la aplicacion,
    ya que espera que la base de datos este arriba y seteada antes de iniciarse.

3. Configuración

    La configuración de la base de datos y otras variables de entorno están definidas en el archivo `docker-compose.yml`. Si necesitas realizar algún cambio, edita este archivo y vuelve a construir los contenedores.

4. Inicialización de la Base de Datos

    El archivo `database.sql` se utiliza para inicializar la base de datos con las tablas necesarias. Este archivo se monta en el contenedor de MySQL y se ejecuta automáticamente al iniciar el contenedor.


## Cambios con respecto a lo solicitado en las instrucciones:

1. Consideré que es mejor usar ruteo que usar archivos php directamente, asi que implemente aquello en vez de tener paginas aparte en el public 
y controladores por otra parte como sugerían las instrucciones, ahora el public solo tiene el ruteo en el index, y la logica esta como en toda aplicación MVC
dentro de los controladores.
2. agregue el template engine de symfony (twig) para lidiar con el html
3. en las funcionalidad se asume que la creacion, edicion y visualizacion de la data del curso es una pagina aparte, sin embargo consideré
que siendo esta una prueba que pedía bootstrap y jquery, el objetivo estaba mejor servido utilizando eventos y modales en vez de hacerlo salir
del flujo de la pagina para hacer algunas de estas acciones, así que lo implementé de esta forma.

## Breve Guía de Uso del Sistema

### Registro de Usuario

1. Accede a la página de registro en [http://localhost/register](http://localhost/register).
2. Completa el formulario con tu nombre, correo electrónico y contraseña.
3. Haz clic en "Registrarse" para crear tu cuenta.

### Inicio de Sesión

1. Accede a la página de inicio de sesión en [http://localhost/login](http://localhost/login).
2. Ingresa tu correo electrónico y contraseña.
3. Haz clic en "Ingresar" para acceder a tu cuenta.

### Gestión de Cursos

#### Crear un Nuevo Curso

1. Inicia sesión en el sistema.
2. Haz clic en "Crear Nuevo Curso" en la página principal de cursos.
3. Completa el formulario en el modal que aparece y haz clic en "Guardar" para crear el curso.

#### Ver Curso

1. Inicia sesión en el sistema.
2. Haz clic en el botón "Ver" junto al curso que deseas ver.
3. Se abrirá un modal con los detalles del curso.

#### Editar Curso

1. Inicia sesión en el sistema.
2. Haz clic en el botón "Editar" junto al curso que deseas editar.
3. Se abrirá un modal con el formulario de edición del curso.
4. Realiza los cambios necesarios y haz clic en "Guardar cambios" para actualizar el curso.

#### Eliminar Curso

1. Inicia sesión en el sistema.
2. Haz clic en el botón "Eliminar" junto al curso que deseas eliminar.
3. Confirma la eliminación en el modal que aparece.

### Salir del Sistema

Haz clic en "Logout" en el menú de navegación para cerrar sesión en el sistema.
