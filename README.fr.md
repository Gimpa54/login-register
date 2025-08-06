# 📌 Login Register

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

2. **Créer la base de données**
	
	- Nom suggéré : base_de_donnees

3. **Configurer le fichier .env**

	- Copier le fichier exemple :
	
	```bash
	cp .env.example .env
	
	- Modifier .env avec vos identifiants.
	
4. **Lancer le serveur**
	
	```bash
	php -S localhost:8000 -t public
	
	- Ou configurer un VirtualHost dans Apache/Nginx.

5. **Accéder à l’application**

	- URL : http://localhost:8000

---

## 📄 Structure du 

	```plaintext
	
	nom-du-projet/
	│
	├── app/            # Code de l’application
	├── public/         # Fichiers accessibles au public
	├── storage/        # Logs, cache, téléchargements
	├── .env.example    # Fichier de configuration d'exemple
	└── README.md       # Documentation du projet


---

## 📄 À propos de .env.example

	- Contient des valeurs d'exemple et sert de modèle pour le fichier .env.
	- Ne contient pas de données réelles.
	- Avant de lancer l'application, copiez-le dans .env et adaptez les valeurs à votre configuration.
	- Le fichier .env ne doit jamais être envoyé sur GitHub (il est déjà inclus dans .gitignore).

---

## 🛠 Technologies utilisées

	- PHP
	- MySQL
	- Bootstrap 5
	- JavaScript / jQuery
	- PHPMailer
	- Dompdf

---

## 🧾 Licence

Copyright (c) 2025 Giampaolo Arienti

<pre>L'autorisation est accordée par la présente, gratuitement, à toute personne obtenant une copie
de ce logiciel et des fichiers de documentation associés (le "Logiciel"), de traiter
du Logiciel sans restriction, y compris sans limitation les droits
d'utiliser, de copier, de modifier, de fusionner, de publier, de distribuer, d'accorder des sous-licences et/ou de vendre
copies du Logiciel, et d'autoriser les personnes à qui le Logiciel est
fourni à le faire, sous réserve des conditions suivantes :

L'avis de droit d'auteur ci-dessus et cet avis d'autorisation doivent être inclus dans toutes les copies
ou parties substantielles du logiciel.

LE LOGICIEL EST FOURNI "TEL QUEL", SANS GARANTIE D'AUCUNE SORTE, EXPRESSE OU
IMPLICITE, Y COMPRIS, MAIS SANS S'Y LIMITER, LES GARANTIES DE QUALITÉ MARCHANDE,
D'ADÉQUATION À UN USAGE PARTICULIER ET D'ABSENCE DE CONTREFAÇON. EN AUCUN CAS LES AUTEURS DE
OU LES TITULAIRES DES DROITS D'AUTEUR NE SERONT RESPONSABLES DES RÉCLAMATIONS, DOMMAGES OU AUTRES RESPONSABILITÉS DE
, QUE CE SOIT DANS LE CADRE D'UNE ACTION CONTRACTUELLE, DÉLICTUELLE OU AUTRE, DÉCOULANT DE,
OU EN LIEN AVEC LE LOGICIEL OU L'UTILISATION OU LES AUTRES UTILISATIONS DU LOGICIEL DE
. </pre>