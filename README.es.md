📄 README.es.md

# Registration

Sistema completo de registro de usuarios

## ✨ Funcionalidades

- Inicio de sesión / Cierre de sesión / Registro
- Recuperación de contraseña por correo electrónico
- Autenticación de dos factores (2FA)
- Gestión de roles y permisos de usuario (administrador, moderador, usuario)
- Tema claro/oscuro
- Soporte multilingüe: Italiano, Inglés, Alemán, Español, Francés, Portugués
- Panel de usuario y panel de administración
- Protección CSRF, tiempo de espera de sesión, limitación de intentos de inicio de sesión
- Logger, validador, cargador, sistema de correo electrónico y más

---

## 📦 Requisitos

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx con `mod_rewrite` habilitado
- Composer (para PHPMailer, dompdf, masterminds/html5 y sabberworm/php-css-parser)

---

## 🚀 Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/your-username/login-register.git
   
2. Crear la base de datos MySQL
	Nombre sugerido: login_register_db
	
4. Configurar el archivo .env
	Copiar el archivo de ejemplo:
	
	```bash
	cp .env.example .env
	
	Editar .env e insertar las credenciales reales (base de datos, correo electrónico, etc.).
	
5. Acceder a la aplicación
	URL por defecto: http://login-register.local

---

📄 Sobre .env.example

	- Contiene valores de ejemplo y sirve como plantilla para el archivo .env.
	- No incluye credenciales reales.
	- Antes de iniciar la aplicación, cópielo en .env y actualice los valores según su configuración.
	- El archivo .env nunca debe subirse a GitHub (ya está incluido en .gitignore).

---

🧾 Licencia

© 2025 Giampaolo Arienti

Este software se publica bajo la licencia MIT. Puede usarlo, copiarlo, modificarlo y distribuirlo para cualquier propósito, incluido el uso comercial, siempre que incluya este aviso y el texto completo de la licencia.

EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍAS DE NINGÚN TIPO.	