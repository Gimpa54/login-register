# Registration

Complete User Registration System

## ✨ Features

- Login / Logout / Registration
- Password recovery via email
- Two-Factor Authentication (2FA)
- User roles and permissions (admin, moderator, user)
- Light/Dark theme support
- Multilanguage support (Italian/English)
- User dashboard and admin panel
- CSRF protection, session timeout, login throttling
- Logger, validator, uploader, mailing system and more

---

## 📦 Requirements

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx with `mod_rewrite` enabled
- Composer (used for PHPMailer)

---

## 🚀 Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/registration.git
   ```

2. Create the MySQL database `registration_db`

3. Copy and configure the `.env` file with your settings

4. Start the server with VirtualHost or run:
   ```bash
   php -S localhost:8000 -t public
   ```

5. Open the app at: [http://registration.local](http://registration.local)

---

## 🧾 MIT License

© 2025 Giampaolo Arienti

This software is released under the MIT License. You are free to use, copy, modify, and distribute it for any purpose, including commercial use, as long as you include this notice and the full license text.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND.
