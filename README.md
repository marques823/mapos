# Map-OS - Sistema de Ordem de Serviço

## Instalação com Docker (Recomendado)

### Pré-requisitos

- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Início Rápido

1. Clone o repositório:
```bash
git clone <url-do-repositorio> mapos
cd mapos
```

2. Configure as variáveis de ambiente:
```bash
cp .env.example .env
# Edite o arquivo .env com suas configurações
```

3. Suba os containers:
```bash
docker-compose up -d
```

4. Instale as dependências PHP:
```bash
docker-compose run --rm composer install --ignore-platform-reqs --no-scripts
```

5. Acesse o sistema:
   - **Aplicação**: `http://localhost:8080`
   - **phpMyAdmin**: `http://localhost:8888`

6. No primeiro acesso, o instalador será exibido automaticamente. Siga as instruções na tela.

### Instalação de Módulos (Docker)

Após a instalação base, acesse `install_modulos_docker.php` para instalar módulos adicionais como Propostas Comerciais.

---

## Instalação Manual (XAMPP/LAMP)

### Pré-requisitos

- PHP 7.4+ com extensões: `mbstring`, `curl`, `gd`, `xml`, `zip`
- MySQL 5.7+ ou MariaDB 10.3+
- Apache com `mod_rewrite` habilitado
- Composer

### Passos

1. Clone o repositório na pasta do servidor web.
2. Execute `composer install` na raiz do projeto.
3. Importe o `banco.sql` no MySQL.
4. Configure o arquivo `application/.env` com as credenciais do banco.
5. Acesse o sistema pelo navegador.

Para instalação automatizada:
- **Linux**: `bash install.sh`
- **Windows**: `install.bat`

---

## Estrutura do Projeto

```
mapos/
├── application/        # Código fonte (CodeIgniter)
├── assets/             # CSS, JS, imagens
├── docker/             # Configurações Docker (Nginx, PHP, Composer)
├── install/            # Instalador web
├── updates/            # Scripts SQL de atualização
├── banco.sql           # Schema inicial do banco
├── docker-compose.yml  # Configuração Docker Compose
├── install.sh          # Script de instalação Linux
├── install.bat         # Script de instalação Windows
└── composer.json       # Dependências PHP
```

## Licença

Veja [LICENSE.txt](LICENSE.txt) para detalhes.
