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

2. **Create the MySQL database**

	Suggested name: login_register_db

3. **Configure the .env file**

	Copy the example file:
	
	```bash
	cp .env.example .env
	
	Edit .env and insert your real credentials (database, email, etc.).

4. **Start the server**

	With Apache/Nginx via VirtualHost or:
	
	```bash
	php -S localhost:8000 -t public

5. **Access the application**

	Default URL: http://login-register.local

---

##📄 About .env.example

	- Contains sample values and serves as a template for the .env file.
	- Does not include real credentials.
	- Before starting the application, copy it t o .env and update the values for your configuration.
	- The .env file must never be committed to GitHub (it is already included in .gitignore).

---

## 🧾 MIT License

Copyright (c) 2025 Giampaolo Arienti

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
