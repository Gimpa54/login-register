📄 README.en.md

# Registration

Complete user registration system

## ✨ Features

- Login / Logout / Registration
- Password recovery via email
- Two-Factor Authentication (2FA)
- User roles and permissions management (admin, moderator, user)
- Light/Dark theme
- Multilanguage support: Italian, English, German, Spanish, French, Portuguese
- User dashboard and administration panel
- CSRF protection, session timeout, login attempt throttling
- Logger, validator, uploader, mailing system, and more

---

## 📦 Requirements

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx with `mod_rewrite` enabled
- Composer (for PHPMailer, dompdf, masterminds/html5, and sabberworm/php-css-parser)

---

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/your-username/login-register.git

2. Create the MySQL database
	Suggested name: login_register_db

3. Configure the .env file
	Copy the example file:
	```bash
	cp .env.example .env
	Edit .env and insert your real credentials (database, email, etc.).

4. Start the server
	With Apache/Nginx via VirtualHost or:
	```bash
	php -S localhost:8000 -t public

5. Access the application
	Default URL: http://login-register.local

---

📄 About .env.example

	- Contains sample values and serves as a template for the .env file.
	- Does not include real credentials.
	- Before starting the application, copy it to .env and update the values for your configuration.
	- The .env file must never be committed to GitHub (it is already included in .gitignore).

---

🧾 License

© 2025 Giampaolo Arienti

This software is released under the MIT License. You are free to use, copy, modify, and distribute it for any purpose, including commercial use, as long as you include this notice and the full license text.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.