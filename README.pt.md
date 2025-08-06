# 📌 Login Register

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

2. **Crie o banco de dados**

	- Nome sugerido: banco_de_dados
	
3. **Configure o arquivo .env**

	- Copie o arquivo de exemplo:
	
	```bash
	cp .env.example .env
	
	- Edite o .env com suas credenciais reais.
	
4. **Iniciar o servidor**
	
	```bash
	php -S localhost:8000 -t public
	
	- Ou configure um VirtualHost no Apache/Nginx.
	
5. **Acessar a aplicação**
	
	- URL: http://localhost:8000
	
---

## 📄 Sobre o .env.example
	- Contém valores de exemplo e serve como modelo para o arquivo .env.
	- Não inclui credenciais reais.
	- Antes de iniciar a aplicação, copie-o para .env e atualize os valores conforme sua configuração.
	- O arquivo .env nunca deve ser enviado para o GitHub (já está incluído no .gitignore).
	
---

## 📄 Estrutura do Projeto

	```plaintext
	
	nome-do-projeto/
	│
	├── app/            # Código da aplicação
	├── public/         # Arquivos públicos
	├── storage/        # Logs, cache, uploads
	├── .env.example    # Arquivo de configuração de exemplo
	└── README.md       # Documentação

---

## 🛠 Tecnologias utilizadas

	- PHP
	- MySQL
	- Bootstrap 5
	- JavaScript / jQuery
	- PHPMailer
	- Dompdf

---

## 🧾 Licença

Direitos de autor (c) 2025 Giampaolo Arienti

<pre>Permissão é aqui concedida, gratuitamente, a qualquer pessoa que obtenha uma cópia
deste software e ficheiros de documentação associados (o "Software"), para negociar
no Software sem restrições, incluindo, sem limitação, os direitos
de utilizar, copiar, modificar, fundir, publicar, distribuir, sublicenciar e/ou vender
cópias do Software, e para permitir que as pessoas a quem o Software é
fornecido o façam, sujeito às seguintes condições:

O aviso de direitos de autor acima e este aviso de permissão devem ser incluídos em todas as cópias
ou partes substanciais do Software.

O SOFTWARE É FORNECIDO "TAL COMO ESTÁ", SEM QUALQUER TIPO DE GARANTIA, EXPRESSA OU
IMPLÍCITA, INCLUINDO MAS NÃO SE LIMITANDO ÀS GARANTIAS DE COMERCIALIZAÇÃO,
ADEQUAÇÃO A UM DETERMINADO FIM E NÃO INFRACÇÃO. EM NENHUMA HIPÓTESE OS AUTORES DE
OU OS TITULARES DOS DIREITOS DE AUTOR SERÃO RESPONSÁVEIS POR QUALQUER RECLAMAÇÃO, DANOS OU OUTRA
RESPONSABILIDADE, SEJA POR UMA ACÇÃO DE CONTRATO, DELITO OU DE OUTRA FORMA, DECORRENTE DE,
FORA DE OU EM CONEXÃO COM O SOFTWARE OU A UTILIZAÇÃO OU OUTRAS ACTIVIDADES NO SOFTWARE
.