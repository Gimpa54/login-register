📄 README.fr.md

# Registration

Système complet d'inscription des utilisateurs

## ✨ Fonctionnalités

- Connexion / Déconnexion / Inscription
- Récupération du mot de passe par e-mail
- Authentification à deux facteurs (2FA)
- Gestion des rôles et permissions des utilisateurs (administrateur, modérateur, utilisateur)
- Thème clair/sombre
- Support multilingue : Italien, Anglais, Allemand, Espagnol, Français, Portugais
- Tableau de bord utilisateur et panneau d'administration
- Protection CSRF, expiration de session, limitation des tentatives de connexion
- Logger, validateur, uploader, système de messagerie et plus encore

---

## 📦 Prérequis

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx avec `mod_rewrite` activé
- Composer (pour PHPMailer, dompdf, masterminds/html5 et sabberworm/php-css-parser)

---

## 🚀 Installation

1. **Cloner le dépôt**
   ```bash
   git clone https://github.com/your-username/login-register.git

2. Créer la base de données MySQL
	Nom suggéré : login_register_db

3. Configurer le fichier .env
	Copier le fichier exemple :
	
	```bash
	cp .env.example .env
	
	Modifier .env et y insérer vos informations réelles (base de données, e-mail, etc.).
	
4. Démarrer le serveur
	Avec Apache/Nginx via VirtualHost ou :
	
	```bash
	php -S localhost:8000 -t public

5. Accéder à l'application
	URL par défaut : http://login-register.local

---

📄 À propos de .env.example

	- Contient des valeurs d'exemple et sert de modèle pour le fichier .env.
	- Ne contient pas de données réelles.
	- Avant de lancer l'application, copiez-le dans .env et adaptez les valeurs à votre configuration.
	- Le fichier .env ne doit jamais être envoyé sur GitHub (il est déjà inclus dans .gitignore).

---

🧾 Licence

© 2025 Giampaolo Arienti

Ce logiciel est publié sous licence MIT. Vous êtes libre de l'utiliser, de le copier, de le modifier et de le distribuer à toute fin, y compris commerciale, tant que vous incluez cet avis et le texte complet de la licence.

LE LOGICIEL EST FOURNI "TEL QUEL", SANS GARANTIE D'AUCUNE SORTE.