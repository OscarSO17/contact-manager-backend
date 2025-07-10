# 📦 Contact Manager API (Backend)

API RESTful construida en PHP para gestionar contactos de usuarios autenticados. Incluye operaciones CRUD completas con validación y manejo de errores.

## ⚡ Características

- PHP puro (sin frameworks), estructurado con MVC ligero
- Patrón Singleton para conexión segura a base de datos
- CRUD completo sobre sobre entidades Contact y User
- Registro e inicio de sesión con hash seguro de contraseñas
- Manejo de errores con mensajes amigables
- Enrutador básico con soporte para CORS
- Base de datos MySQL en la nube (Railway)

## 📂 Estructura de carpetas

```
├── 📁 api/                 # Endpoints públicos de la API
│└── 📄 contacts.php     # Enrutador básico que maneja las peticiones HTTP de los contactos (CRUD)
│└── 📄 users.php        # Enrutador básico que maneja las peticiones HTTP de los usuarios (Registro Y Login)
├── 📁 conf/                # Configuración de la conexión a la base de datos
│└── 📄 database.php     # Clase Singleton para gestionar conexión segura a MySQL
├── 📁 controller/          # Controladores con la lógica de negocio de la aplicación
│└── 📄 ContactController.php  # Encapsula operaciones CRUD con respuestas amigables de los contactos
│└── 📄 UserController.php  # Encapsula operaciones CRUD con respuestas amigables de los usuarios
├── 📁 dao/                 # Data Access Object (DAO) para consultas SQL
│└── 📄 ContactDAO.php   # Acceso a base de datos con consultas preparadas para los contactos
│└── 📄 UserDAO.php      # Acceso a base de datos con consultas preparadas para los usuarios
├── 📁 model/               # Modelos de entidades del dominio
│└── 📄 Contact.php      # Representa la estructura de un Contacto
│└── 📄 User.php         # Representa la estructura de un usuario
├── 📁 sql/                 # Scripts SQL para la base de datos
│└── 📄 schema.sql       # Script de creación de las tablas y base de datos
📄 .env.example             # Archivo de ejemplo para variables de entorno
📄 .gitignore               # Archivos y carpetas a excluir en el repositorio
📄 README.md                # Documentación del proyecto
```

## 🛠️ Tecnologías

- PHP 8+
- MySQL
- Railway (para despliegue de BD)

## 📜 Instalación

1️⃣ Clona este repositorio
git clone https://github.com/OscarSO17/contact-manager-backend.git



2️⃣ Crea tu archivo `.env` basado en el `.env.example`:
DB_HOST=...
DB_PORT=...
DB_NAME=...
DB_USER=...
DB_PASSWORD=...


3️⃣ Importa el schema con el archivo `sql/schema.sql`

```
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150),
    phone VARCHAR(30),
    notes VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

4️⃣ Despliega o prueba localmente con tu servidor PHP

## 🚀 Endpoints

Usuarios
- POST /api/users.php?path=register
- POST /api/users.php?path=login

Contactos:
- GET /api/index.php?path=contacts
- GET /api/index.php?path=contact&id=1
- POST /api/index.php?path=contact
- PUT /api/index.php?path=contact&id=1
- DELETE /api/index.php?path=contact&id=1

## ✅ Estado

✔️ Proyecto en fase de aprendizaje.  
✔️ Listo para prácticas y pruebas de consumo desde Frontend.  
✔️ Pensado como base para prácticas Full Stack.

---

**Desarrollado por Oscar Serrano**
