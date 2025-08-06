# Login Register

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
   
2. **MySQL-Datenbank erstellen**

	Vorgeschlagener Name: login_register_db
	
3. **Die Datei .env konfigurieren**

	Beispieldatei kopieren:
	
	```bash
	cp .env.example .env

	.env bearbeiten und Ihre echten Zugangsdaten (Datenbank, E-Mail usw.) einfügen.
	
4. **Server starten**

	Mit Apache/Nginx über VirtualHost oder:
	
	```bash
	php -S localhost:8000 -t public
	
5. **Auf die Anwendung zugreifen**

	Standard-URL: http://localhost:8000
	- Composer (für PHPMailer, dompdf, masterminds/html5 und sabberworm/php-css-parser)

---

## 📄 Projektstruktur
	plaintext

	projektname/
	│
	├── app/            # Anwendungslogik
	├── public/         # Öffentlich zugängliche Dateien
	├── storage/        # Logs, Cache, Uploads
	├── .env.example    # Beispiel-Konfigurationsdatei
	└── README.md       # Dokumentation

---

## 🛠 Verwendete Technologien

	- PHP
	- MySQL
	- Bootstrap 5
	- JavaScript / jQuery
	- PHPMailer
	- Dompdf
	
---
	
## 📄 Über .env.example

	- Enthält Beispielwerte und dient als Vorlage für die .env-Datei.
	- Enthält keine echten Zugangsdaten.
	- Vor dem Start der Anwendung in .env kopieren und Werte entsprechend Ihrer Konfiguration anpassen.
	- Die .env-Datei darf niemals in GitHub hochgeladen werden (sie ist bereits in .gitignore enthalten).

---
	
## 🧾 Lizenz

Urheberrecht (c) 2025 Giampaolo Arienti

<pre>Jeder Person, die eine Kopie
dieser Software und der zugehörigen Dokumentationsdateien (die "Software") erwirbt, wird hiermit kostenlos die Erlaubnis erteilt,
mit der Software uneingeschränkt zu handeln, einschließlich und ohne Einschränkung der Rechte
, Kopien der Software zu verwenden, zu kopieren, zu modifizieren, zusammenzuführen, zu veröffentlichen, zu vertreiben, Unterlizenzen zu vergeben und/oder
Kopien der Software zu verkaufen, und Personen, denen die Software
zur Verfügung gestellt wird, dies zu gestatten, vorbehaltlich der folgenden Bedingungen:

Der obige Copyright-Hinweis und dieser Genehmigungshinweis müssen in allen
Kopien oder wesentlichen Teilen der Software enthalten sein.

DIE SOFTWARE WIRD OHNE MÄNGELGEWÄHR ZUR VERFÜGUNG GESTELLT, OHNE AUSDRÜCKLICHE ODER
STILLSCHWEIGENDE GEWÄHRLEISTUNG JEGLICHER ART, EINSCHLIESSLICH, ABER NICHT BESCHRÄNKT AUF DIE GEWÄHRLEISTUNG DER MARKTGÄNGIGKEIT,
EIGNUNG FÜR EINEN BESTIMMTEN ZWECK UND NICHTVERLETZUNG VON RECHTEN. IN KEINEM FALL SIND DIE
AUTOREN ODER URHEBER FÜR IRGENDWELCHE ANSPRÜCHE, SCHADENSERSATZANSPRÜCHE ODER SONSTIGE
HAFTUNG, SEI ES BEI EINER VERTRAGSKLAGE, EINEM UNERLAUBTEN HANDEL ODER AUF ANDERE WEISE, HAFTBAR, DIE AUS, DURCH ODER IM ZUSAMMENHANG MIT DER SOFTWARE ODER DER NUTZUNG ODER ANDEREN HANDLUNGEN DER
SOFTWARE ENTSTEHEN.</pre>