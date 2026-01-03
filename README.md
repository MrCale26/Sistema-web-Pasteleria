# 🍰 Sistema Web de Pastelería

Sistema Web de Pastelería desarrollado en **PHP bajo el patrón MVC**, orientado a la gestión de productos, pedidos y pagos, con un panel de administración y un panel para clientes.

Este proyecto fue desarrollado como un sistema completo que simula el funcionamiento real de una pastelería, permitiendo ventas en línea, pedidos personalizados y control administrativo.

---

## 📌 Características principales

### 👤 Cliente

* Registro e inicio de sesión
* Catálogo de productos por categorías
* Carrito de compras
* Realización de pedidos
* Pagos (simulación / integración preparada)
* Historial de pedidos
* Panel de cliente

### 🛠️ Administrador

* Dashboard administrativo
* Gestión de productos (CRUD)
* Gestión de categorías
* Gestión de usuarios y empleados
* Visualización y control de pedidos
* Seguimiento de entregas
* Reportes y pagos

---

## 🧱 Arquitectura del sistema

El proyecto sigue el patrón **MVC (Modelo – Vista – Controlador)**:

* **Models**: Manejo de datos y lógica de negocio
* **Controllers**: Control del flujo de la aplicación
* **Views**: Interfaz de usuario (admin y cliente)

---

## 🗂️ Estructura del proyecto

```
pasteleria_pro/
│── assets/            # Imágenes, videos y recursos
│── config/            # Configuración y conexión a BD
│── controllers/       # Controladores MVC
│── helpers/           # Funciones auxiliares
│── models/            # Modelos
│── public/            # CSS y recursos públicos
│── uploads/           # Imágenes de productos (ignorado en Git)
│── views/             # Vistas del sistema
│── index.php          # Punto de entrada
│── .htaccess          # Reglas de rutas
```

---

## 🗄️ Base de datos

La base de datos del sistema está diseñada en **MySQL** y soporta la gestión completa de productos, usuarios, pedidos, pagos y entregas.

### 📂 Script SQL

El script de la base de datos se encuentra en:

```
database/pasteleria.sql
```

Este archivo incluye:

* Creación de tablas
* Relaciones (claves foráneas)
* Datos de prueba para demostración

---

### 🧩 Tablas principales

* **usuarios**: gestión de cuentas (admin / cliente)
* **empleados**: personal del sistema
* **roles**: control de permisos
* **categorias**: clasificación de productos
* **productos**: catálogo de la pastelería
* **ventas**: pedidos realizados
* **detalles_ventas**: detalle de productos por pedido
* **pedidos_personalizados**: pedidos especiales
* **entregas**: seguimiento de entregas
* **transacciones_pagos**: control de pagos

---

### 🔗 Relaciones destacadas

* Un **usuario** puede realizar muchos **pedidos**
* Una **venta** tiene muchos **detalles_ventas**
* Un **producto** pertenece a una **categoría**
* Una **venta** puede tener una **entrega** asociada

---

### ⚙️ Importación de la base de datos

1. Crear una base de datos llamada:

```
pasteleria_db
```

2. Importar el archivo:

```
database/pasteleria.sql
```

3. Configurar la conexión en:

```
config/database.php
```

---

## 🧰 Tecnologías utilizadas

* **PHP 8+**
* **MySQL**
* **HTML5 / CSS3**
* **JavaScript**
* **Bootstrap**
* **Git & GitHub**
* **XAMPP** (entorno local)

---

## ⚙️ Instalación y ejecución (XAMPP)

1. Clonar el repositorio:

```bash
git clone https://github.com/MrCale26/Sistema-web-Pasteleria.git
```

2. Copiar el proyecto en:

```
C:/xampp/htdocs/
```

3. Crear la base de datos en **phpMyAdmin**

4. Configurar la conexión en:

```
config/database.php
```

5. Iniciar Apache y MySQL desde XAMPP

6. Acceder desde el navegador:

```
http://localhost/pasteleria_pro
```

---

## 🔐 Seguridad

* Contraseñas cifradas
* Manejo de sesiones
* Separación de roles (admin / cliente)
* Acceso controlado a vistas administrativas

---

## 📸 Capturas del sistema

> Se recomienda agregar capturas del:

* Catálogo de productos
* Carrito de compras
* Panel administrador
* Dashboard

---

## 👨‍💻 Autor

**Alexander Capitan**
Desarrollador Web
GitHub: [MrCale26](https://github.com/MrCale26)

---

## 📄 Licencia

Proyecto desarrollado con fines académicos y educativos.
