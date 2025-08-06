# Registration

Sistema completo di registrazione utente

## ✨ Caratteristiche

- Login / Logout / Registrazione
- Recupero password via email
- Verifica a due fattori (2FA)
- Ruoli e permessi (admin, moderatore, utente)
- Tema chiaro/scuro
- Supporto multilingua (Italiano/Inglese)
- Dashboard utente e pannello amministratore
- Protezione CSRF, timeout di sessione, limitatore tentativi login
- Logger, validatore, uploader, sistema mail e altro

---

## 📦 Requisiti

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx con `mod_rewrite` abilitato
- Composer (per PHPMailer)

---

## 🚀 Installazione

1. Clona il progetto:
   ```bash
   git clone https://github.com/tuo-utente/login-register.git
   ```

2. Crea il database `login_register_db` in MySQL

3. Copia e configura il file `.env` con le tue credenziali

4. Avvia Apache con VirtualHost o:
   ```bash
   php -S localhost:8000 -t public
   ```

5. Accedi all'app: [http://login-register.local](http://login-register.local)

---

## 🧾 Licenza MIT

© 2025 Giampaolo Arienti

Questo software è distribuito con Licenza MIT. Puoi usarlo, copiarlo, modificarlo e distribuirlo liberamente, anche per scopi commerciali, a patto di includere questa nota e la licenza completa nei file distribuiti.

IL SOFTWARE VIENE FORNITO "COSÌ COM'È", SENZA GARANZIE DI ALCUN TIPO.
