# Nombre del Proyecto

> My Dance Academy

## Tabla de Contenidos

- [Descripción del Proyecto](#descripción-del-proyecto)
- [Tecnologías Usadas](#tecnologías-usadas)
- [Requisitos del Sistema](#requisitos-del-sistema)
- [Instalación](#instalación)
- [Comandos Iniciales](#comandos-iniciales)
- [Base de Datos](#base-de-datos)
- [Estructura del Proyecto](#estructura-del-proyecto)
- [Contribuir](#contribuir)
- [Licencia](#licencia)

## Descripción del Proyecto

Este software es una solución completa que reúne todas las herramientas necesarias para organizar y simplificar la administración de tu academia. Desde la gestión de estudiantes y clases hasta el control de pagos y reportes, cada módulo ha sido creado para ayudarte a tener un manejo profesional, ordenado y eficiente de tu academia.

## Tecnologías Usadas

Este proyecto utiliza las siguientes tecnologías y paquetes:

### Backend
- **Laravel**: Framework PHP utilizado para el desarrollo backend.
- **Jetstream**: Paquete de Laravel para la autenticación de usuarios y administración de sesiones.
- **Sanctum**: Paquete para la autenticación de API en Laravel.
- **JWT-Auth**: Paquete para la autenticación utilizando tokens JWT.
- **Spatie Laravel Permission**: Paquete para gestionar roles y permisos de usuarios.
- **Livewire**: Paquete para crear interfaces dinámicas sin escribir JavaScript.

### Frontend
- **Tailwind CSS**: Framework CSS para diseño y estilos rápidos y personalizables.
- **Vite**: Herramienta de construcción moderna para proyectos frontend, utilizada en Laravel para empaquetar y optimizar activos.
- **Alpine.js**: Framework JavaScript ligero para agregar interactividad a las vistas sin necesidad de un framework complejo como Vue.js o React.
- **Livewire**: (también en frontend) Para construir interfaces dinámicas y reactivas utilizando PHP, sin necesidad de escribir mucho JavaScript.
- **Laravel Mix**: Herramienta para compilar assets, aunque en Laravel 9+ se ha sustituido por Vite, Mix sigue siendo una opción popular en proyectos anteriores.
- **Sass** (opcional): Si estás utilizando Sass para la compilación de CSS.

### Otras herramientas y librerías
- **Faker**: Paquete para generar datos ficticios en el desarrollo.
- **Concurrently**: Paquete para ejecutar múltiples procesos de forma simultánea en el entorno de desarrollo.
- **Axios**: Para realizar solicitudes HTTP desde el frontend (si se usa en el proyecto).
- **Alpine.js**: Framework minimalista de JavaScript utilizado para agregar interactividad sin la necesidad de frameworks complejos.

## Requisitos del Sistema

Antes de comenzar, asegúrate de tener instalados los siguientes requisitos en tu sistema:

- **PHP** 8.2 o superior
- **Composer** para gestionar dependencias
- **Node.js** y **npm** para las dependencias front-end
- **Docker** (si estás utilizando Laravel Sail)

## Instalación

Sigue estos pasos para instalar el proyecto en tu máquina local:

1. Clona el repositorio:
    ```bash
    git clone https://github.com/fabianrojasSab/bailaPro-laravel.git
    ```

2. Navega a la carpeta del proyecto:
    ```bash
    cd bailaPro-laravel
    ```

3. Instala las dependencias de PHP con Composer:
    ```bash
    composer install
    ```

4. Instala las dependencias de JavaScript con npm:
    ```bash
    npm install
    ```

5. Crea el archivo `.env` a partir del archivo de ejemplo:
    ```bash
    cp .env.example .env
    ```

6. Genera la clave de la aplicación de Laravel:
    ```bash
    php artisan key:generate
    ```

7. (Opcional) Si estás usando Docker, inicia Sail:
    ```bash
    ./vendor/bin/sail up
    ```

8. Si no usas Sail, puedes iniciar el servidor de desarrollo con:
    ```bash
    php artisan serve
    ```

## Comandos Iniciales

Algunos de los comandos más utilizados en el proyecto:
- **Levantar los estaticos**:
    ```bash
    npm run rev
    ```

- **Levantar el servidor local**:
    ```bash
    php artisan serve
    ```

- **Correr las migraciones de la base de datos y los datos base**:
    ```bash
    php artisan migrate --seed --force
    ```

- **Generar un nuevo controlador**:
    ```bash
    php artisan make:livewire NombreController
    ```

- **Generar un nuevo modelo**:
    ```bash
    php artisan make:model NombreDelModelo
    ```

- **Generar una nueva migración**:
    ```bash
    php artisan make:migration nombre_de_migracion
    ```


##  Convenciones usadas

- Modelos: Singular, PascalCase (User, OrderItem).
- Tablas: Plural, minúsculas y con guiones bajos (users, order_items).
- Controladores: PascalCase con Controller al final (UserController, ProductController).
- Rutas: Minúsculas, kebab-case (/user-profile, /order-items).
- Interfaces: PascalCase con prefijo I (IUserRepository, IProductService).
- Servicios y Repositorios: PascalCase (UserService, ProductRepository).
- Middleware: PascalCase (Authenticate, CheckAge).
- Migraciones: create_{table_name}_table (create_users_table).
- Factories: Singular, con Factory al final (UserFactory, ProductFactory).
- Políticas: PascalCase, {Model}Policy (ProductPolicy, UserPolicy).

## Documentation

[Documentation](https://linktodocumentation)


## Authors
- [@juan-ubaque](https://github.com/juan-ubaque)
- [@fabianrojasSab](https://github.com/fabianrojasSab)
## Licencia

Este proyecto está protegido por **todos los derechos reservados**. No se permite la modificación, distribución ni uso del software sin el permiso explícito del titular de los derechos de autor.

**Copyright (c) 2024 BytecreaColombia. Todos los derechos reservados.**