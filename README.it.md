📄 README.it.md

# Registration

Sistema completo di registrazione utente

## ✨ Caratteristiche

- Login / Logout / Registrazione
- Recupero password via email
- Verifica a due fattori (2FA)
- Ruoli e permessi (admin, moderatore, utente)
- Tema chiaro/scuro
- Supporto multilingua: Italiano, Inglese, Tedesco, Spagnolo, Francese, Portoghese
- Dashboard utente e pannello amministratore
- Protezione CSRF, timeout di sessione, limitatore tentativi login
- Logger, validatore, uploader, sistema mail e altro

---

## 📦 Requisiti

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx con `mod_rewrite` abilitato
- Composer (per PHPMailer, dompdf, masterminds e sabberworm)

---

## 🚀 Installazione

1. Clona il progetto:
   ```bash
   git clone https://github.com/tuo-utente/login-register.git
   
2. Crea il database login_register_db in MySQL

3. Copia il file .env.example in .env:

	```bash
	cp .env.example .env

	Apri .env e inserisci le tue credenziali reali (database, email, ecc.).
	
4. Avvia Apache con VirtualHost o:
   ```bash
   php -S localhost:8000 -t public
   
5. Accedi all'app: http://login-register.local

---

## 📄 Note su .env.example

	- Il file .env.example contiene valori di esempio e serve come modello.
	- Non contiene credenziali reali.
	- Prima di avviare l'app, copia .env.example in .env e modifica i valori secondo la tua configurazione.
	- Il file .env non va mai caricato su GitHub (è già nel .gitignore).

---

## 🧾 Licenza MIT

© 2025 Giampaolo Arienti

Questo software è distribuito con Licenza MIT. Puoi usarlo, copiarlo, modificarlo e distribuirlo liberamente, anche per scopi commerciali, a patto di includere questa nota e la licenza completa nei file distribuiti.

IL SOFTWARE VIENE FORNITO "COSÌ COM'È", SENZA GARANZIE DI ALCUN TIPO.
