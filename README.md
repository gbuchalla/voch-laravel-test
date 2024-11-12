## Projeto Teste - Voch Tech

### Instalação e Execução

Este projeto pode ser instalado de duas formas diferentes:

1. **Instalação com Laravel Sail (Docker)**.
   
2. **Instalação tradicional (sem Docker, com PHP + MySQL instalados localmente)**.

Escolha uma das opções abaixo para instalar e rodar o projeto.

### Instalação e configuração com Laravel Sail (Docker)
---


***Requisito:***
- Docker Desktop.
- Em caso de utilizar o window: ter o WSL 2 (Windows Subsystem for Linux), para executar os comandos em terminal Linux/Bash. 

***Etapas:***

1. **Clone o repositório e entre no diretório do projeto:**

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

2. **Instale as dependências do Composer dentro do ambiente Docker:**

*OBS:* Isso irá usar imagens Docker com PHP e Composer para instalar o Laravel Sail e dependências do projeto.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

3. **Copie o arquivo `.env.example` e renomeie a cópia para `.env`:**

```bash
cp .env.example .env
```

4. **Se preferir, edite o arquivo `.env` para configurar as credenciais do banco de dados (MySQL).**


5. **Inicie os containers do Docker por meio do Sail:**

```bash
./vendor/bin/sail up -d
```

6. **Gere uma chave da aplicação:**

```bash
./vendor/bin/sail artisan key:generate 
```

7. **Cria as tabelas do banco de dados executando as migrações:**

```bash
./vendor/bin/sail  artisan migrate
```

8. **Popule o banco de dados com o comando:**

```bash
./vendor/bin/sail artisan db:seed
```

9. **Acesse a aplicação em [http://localhost](http://localhost)**.



### Instalação e configuração sem Docker
---

***Requisitos:***
- PHP ^8.1 ou superior.
- Composer.
- MySQL (ou MariaDB) configurado localmente.

***Etapas:***

1. **Clone o repositório e entre no diretório do projeto:**

```bash
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

2. **Instale as dependências com o Composer:**

```bash
composer install
```

3. **Copie o arquivo `.env.example` para `.env`:**

```bash
cp .env.example .env
```

4. **Se preferir, edite o arquivo `.env` para configurar as credenciais do banco de dados (MySQL)**.

5. **Gere a chave da aplicação:**

```bash
php artisan key:generate 
```

6. **Cria as tabelas do banco de dados executando as migrações:**

```bash
php artisan migrate
```

7. **Popule o banco de dados com o comando:**
```bash
php artisan db:seed
```

8. **Inicie o servidor local:**

```bash
php artisan serve
```

9. **Acesse a aplicação em [http://localhost](http://localhost)**.

<br>

---

 
### ✉️ Contato:
Em caso de dúvida, você pode me contatar por [e-mail](mailto:guibuchalla@gmail.com).
