# 📌 Login Register

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
- Logger, validador, cargador, sistema de correo electrónico y más...

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
   
2. **Crear la base de datos MySQL**
	
	- Nombre sugerido: login_register_db
	
3. **Configurar el archivo .env**
	
	- Copiar el archivo de ejemplo:
	
	```bash
	cp .env.example .env

	- Editar .env con tus credenciales reales.
	
4. **Iniciar el servidor**
	
	```bash
	php -S localhost:8000 -t public

	- O configurar un VirtualHost en Apache/Nginx.
	
5. **Acceder a la aplicación**

	 - URL: http://localhost:8000

---

## 📄 Estructura del Proyecto

	```plaintext

	nombre-proyecto/
	│
	├── app/            # Código de la aplicación
	├── public/         # Archivos públicos
	├── storage/        # Logs, caché, subidas
	├── .env.example    # Archivo de configuración de ejemplo
	└── README.md       # Documentación


---

##🛠 Tecnologías utilizadas

	- PHP
	- MySQL
	- Bootstrap 5
	- JavaScript / jQuery
	- PHPMailer
	- Dompdf

---

##📄 Sobre .env.example

	- Contiene valores de ejemplo y sirve como plantilla para el archivo .env.
	- No incluye credenciales reales.
	- Antes de iniciar la aplicación, cópielo en .env y actualice los valores según su configuración.
	- El archivo .env nunca debe subirse a GitHub (ya está incluido en .gitignore).

---

🧾 Licencia

Copyright (c) 2025 Giampaolo Arienti

<pre>Por la presente se concede permiso, de forma gratuita, a cualquier persona que obtenga una copia
de este software y de los archivos de documentación asociados (el "Software"), para tratar
con el Software sin restricciones, incluidos, entre otros, los derechos
a utilizar, copiar, modificar, fusionar, publicar, distribuir, sublicenciar y/o vender
copias del Software, y a permitir que las personas a las que se proporcione el Software
lo hagan, sujeto a las siguientes condiciones:

El aviso de copyright anterior y este aviso de permiso se incluirán en todas las copias o partes sustanciales del Software de
.

EL SOFTWARE SE PROPORCIONA "TAL CUAL", SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O IMPLÍCITA
, INCLUIDAS, ENTRE OTRAS, LAS GARANTÍAS DE COMERCIABILIDAD, IDONEIDAD PARA UN FIN DETERMINADO Y NO INFRACCIÓN DE
. EN NINGÚN CASO LOS AUTORES DE
O LOS TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE NINGUNA RECLAMACIÓN, DAÑO U OTRA RESPONSABILIDAD DE
, YA SEA POR ACCIÓN CONTRACTUAL, AGRAVIO O DE CUALQUIER OTRO TIPO, DERIVADA DE,
O RELACIONADA CON EL SOFTWARE O CON EL USO U OTRAS OPERACIONES CON EL SOFTWARE
.</pre>