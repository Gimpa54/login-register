📄 README.pt.md

# Registration

Sistema completo de registro de usuários

## ✨ Funcionalidades

- Login / Logout / Registro
- Recuperação de senha por e-mail
- Autenticação de dois fatores (2FA)
- Gerenciamento de funções e permissões de usuários (administrador, moderador, usuário)
- Tema claro/escuro
- Suporte multilíngue: Italiano, Inglês, Alemão, Espanhol, Francês, Português
- Painel do usuário e painel de administração
- Proteção CSRF, tempo limite de sessão, limitação de tentativas de login
- Logger, validador, uploader, sistema de e-mail e muito mais

---

## 📦 Requisitos

- PHP >= 8.1
- MySQL / MariaDB
- Apache/Nginx com `mod_rewrite` habilitado
- Composer (para PHPMailer, dompdf, masterminds/html5 e sabberworm/php-css-parser)

---

## 🚀 Instalação

1. **Clonar o repositório**
   ```bash
   git clone https://github.com/your-username/login-register.git

2. Criar o banco de dados MySQL
	Nome sugerido: login_register_db
	
3. Configurar o arquivo .env
	Copiar o arquivo de exemplo:
	
	```bash
	cp .env.example .env
	
	Editar .env e inserir suas credenciais reais (banco de dados, e-mail, etc.).
	
4. Iniciar o servidor
	Com Apache/Nginx via VirtualHost ou:
	
	```bash
	php -S localhost:8000 -t public
	
5. Acessar a aplicação
	URL padrão: http://login-register.local

---


📄 Sobre o .env.example
	- Contém valores de exemplo e serve como modelo para o arquivo .env.
	- Não inclui credenciais reais.
	- Antes de iniciar a aplicação, copie-o para .env e atualize os valores conforme sua configuração.
	- O arquivo .env nunca deve ser enviado para o GitHub (já está incluído no .gitignore).
	
---


🧾 Licença

© 2025 Giampaolo Arienti

Este software é distribuído sob a Licença MIT. Você pode usá-lo, copiá-lo, modificá-lo e distribuí-lo para qualquer finalidade, incluindo uso comercial, desde que inclua este aviso e o texto completo da licença.

O SOFTWARE É FORNECIDO "NO ESTADO EM QUE SE ENCONTRA", SEM GARANTIA DE QUALQUER TIPO.