<img width=100% src="https://capsule-render.vercel.app/api?type=waving&color=00CA76&height=120&section=header"/>

[![Typing SVG](https://readme-typing-svg.herokuapp.com/?color=00CA76&size=35&center=true&vCenter=true&width=1000&lines=Dashboard+do+ByteCode;)](https://git.io/typing-svg) 

<p align="center">
Dashboard desenvolvido para o bot <strong>ByteCode</strong> no Discord. Através deste painel, é possível personalizar comandos, configurar mensagens de boas-vindas, gerenciar a fila de músicas e acessar diversas funções administrativas.
</p>

## 🛠️ Funcionalidades

- 🔧 Personalizar o **prefixo dos comandos**
- 👋 Configurar a **mensagem de boas-vindas**
- 🎶 Gerenciar e visualizar a **fila de músicas**
- 🗂️ Gerenciamento de comandos do bot
- 🚀 Acessar outras funções exclusivas para administração do bot

## 🚀 Tecnologias Utilizadas

<div align="center">

<code><img height="32" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/php/php.png" alt="PHP"/></code>
<code><img height="32" src="https://raw.githubusercontent.com/marwin1991/profile-technology-icons/refs/heads/main/icons/mysql.png" alt="MySQL"/></code>
<code><img height="32" src="https://raw.githubusercontent.com/Lucasmassaroto1/Lucasmassaroto1/main/xampp.png" alt="Xampp"/></code>
<code><img height="32" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/javascript/javascript.png" alt="Javascript"/></code>
<code><img height="32" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/html/html.png" alt="HTML5"/></code>
<code><img height="32" src="https://raw.githubusercontent.com/github/explore/80688e429a7d4ef2fca1e82350fe8e3517d3494d/topics/css/css.png" alt="CSS"/></code>

</div>

## 🖥️ Executando Localmente

Para executar localmente este projeto na sua máquina, siga os passos abaixo utilizando o XAMPP:

### 📌 Pré-requisitos

- Ter o **[XAMPP](https://www.apachefriends.org/index.html)** instalado
- Clonar ou baixar este repositório

### 🧩 Passos

1. Abra o painel do **XAMPP** e **inicie** os serviços `Apache` e `MySQL`.

2. Copie ou mova a pasta do projeto para dentro da pasta `htdocs`.  
   Exemplo no Windows:

   ```
   C:\xampp\htdocs\ProjetoGazinCRUD
    ```

3. Importe o banco de dados:

- Acesse o [phpMyAdmin](http://localhost/phpmyadmin)
- Crie um banco de dados com o nome desejado (ex: `bytecrud`)
- Vá na aba **Importar** e selecione o arquivo:
  ```
  sql/bytecrud.sql
  ```

4. Edite o arquivo de configuração com os dados do seu banco:
    ```
    includes/config/config.php
    ```

5. No navegador, acesse:

    ```
    http://localhost/ProjetoGazinCRUD/public/
    ```
6. ✅ Pronto! A dashboard estará carregando com os dados do projeto.

> ⚠️ Certifique-se de que o banco de dados MySQL está configurado corretamente, conforme o arquivo `config.php` no diretório `includes/config`.

## 📫 Contato
<div align="center">

<a href="https://www.tiktok.com/@lucasmassaroto1" target="_blank"><code><img height="32" src="https://uxwing.com/wp-content/themes/uxwing/download/brands-and-social-media/tiktok-color-icon.png" alt="TikTok"/></code></a>
<a href="https://www.instagram.com/lucasmassaroto17" target="_blank"><code><img height="32" src="https://skillicons.dev/icons?i=instagram" alt="Instagram"/></code></a>
<a href="mailto:lucasmassaroto17@gmail.com" target="_blank"><code><img height="32" src="https://skillicons.dev/icons?i=gmail" alt="gmail"/></code></a>
</div>

<img width=100% src="https://capsule-render.vercel.app/api?type=waving&color=00CA76&height=120&section=footer"/>
