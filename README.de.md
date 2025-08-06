📄 README.de.md

# Registration

Komplettes Benutzerregistrierungssystem

## ✨ Funktionen

- Login / Logout / Registrierung
- Passwort-Wiederherstellung per E-Mail
- Zwei-Faktor-Authentifizierung (2FA)
- Verwaltung von Benutzerrollen und Berechtigungen (Admin, Moderator, Benutzer)
- Helles/Dunkles Design
- Mehrsprachige Unterstützung: Italienisch, Englisch, Deutsch, Spanisch, Französisch, Portugiesisch
- Benutzer-Dashboard und Administrationsbereich
- CSRF-Schutz, Sitzungs-Timeout, Begrenzung der Anmeldeversuche
- Logger, Validator, Uploader, E-Mail-System und mehr

---

## 📦 Anforderungen

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx mit aktiviertem `mod_rewrite`
- Composer (für PHPMailer, dompdf, masterminds/html5 und sabberworm/php-css-parser)

---

## 🚀 Installation

1. **Repository klonen**
   ```bash
   git clone https://github.com/your-username/login-register.git
   
2. MySQL-Datenbank erstellen
	Vorgeschlagener Name: login_register_db
	
3. Die Datei .env konfigurieren
	Beispieldatei kopieren:
	
	```bash
	cp .env.example .env

	.env bearbeiten und Ihre echten Zugangsdaten (Datenbank, E-Mail usw.) einfügen.
	
4. Server starten
	Mit Apache/Nginx über VirtualHost oder:
	
	```bash
	php -S localhost:8000 -t public
	
5. Auf die Anwendung zugreifen
	Standard-URL: http://login-register.local
- Composer (für PHPMailer, dompdf, masterminds/html5 und sabberworm/php-css-parser)

---
	
📄 Über .env.example

	- Enthält Beispielwerte und dient als Vorlage für die .env-Datei.
	- Enthält keine echten Zugangsdaten.
	- Vor dem Start der Anwendung in .env kopieren und Werte entsprechend Ihrer Konfiguration anpassen.
	- Die .env-Datei darf niemals in GitHub hochgeladen werden (sie ist bereits in .gitignore enthalten).

---
	
🧾 Lizenz

© 2025 Giampaolo Arienti

Diese Software wird unter der MIT-Lizenz veröffentlicht. Sie dürfen sie für beliebige Zwecke, einschließlich kommerzieller Nutzung, verwenden, kopieren, ändern und weitergeben, sofern dieser Hinweis und der vollständige Lizenztext enthalten sind.

DIE SOFTWARE WIRD "WIE BESEHEN" BEREITGESTELLT, OHNE JEGLICHE GARANTIEN.
