# Login Register

## 🇮🇹 Italiano – Come usare .env.example

## 🔧 Configurazione ambiente

	- Il file .env.example contiene un esempio della configurazione necessaria per far funzionare correttamente l'applicazione.
	
1. **Duplica** il file .env.example:

	```bash
	cp .env.example .env

2. **Modifica** il file .env con le tue credenziali:

	- Imposta i dati di connessione al database (DB_HOST, DB_NAME, ecc.)
	- Configura il servizio email (MAIL_HOST, MAIL_USERNAME, ecc.)
	- Imposta l’URL della tua applicazione (APP_URL)
	- Imposta limiti come MAX_UPLOAD_MB e SESSION_TIMEOUT

⚠️ Non modificare direttamente .env.example: questo file è un modello di riferimento.

---

## 🇬🇧 English – How to use .env.example

## 🔧 Environment configuration

	- The .env.example file contains a sample configuration required to run the application correctly.

1. **Duplicate** the .env.example file:

	```bash
	cp .env.example .env

2. **Edit** the .env file with your own settings:

	- Set database credentials (DB_HOST, DB_NAME, etc.)
	- Configure email service (MAIL_HOST, MAIL_USERNAME, etc.)
	- Set the app URL (APP_URL)
	- Set limits like MAX_UPLOAD_MB and SESSION_TIMEOUT

⚠️ Do not edit .env.example directly – this file is just a reference template.

---
