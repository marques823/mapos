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

2. Configure as variáveis de ambiente do Docker:
```bash
cp docker/.env.example docker/.env
# Edite docker/.env se necessário (portas, senhas, etc.)
```

3. Suba os containers (de dentro da pasta `docker/`):
```bash
cd docker
docker-compose up -d
```

4. Instale as dependências PHP:
```bash
docker-compose run --rm composer install --ignore-platform-reqs --no-scripts
```

5. Acesse o sistema:
   - **Aplicação**: `http://localhost:8000`
   - **phpMyAdmin**: `http://localhost:8080`

6. No primeiro acesso, o instalador será exibido automaticamente. Siga as instruções na tela.

### Instalação de Módulos (Docker)

Após a instalação base, acesse `install_modulos_docker.php` para instalar módulos adicionais como Propostas Comerciais.

> **Nota:** O arquivo `docker/.env` é **local** e não é rastreado pelo git. Use `docker/.env.example` como referência. Isso permite rodar o Docker e o XAMPP/LAMP ao mesmo tempo sem conflitos de portas.

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
├── docker/             # Configurações Docker (isolado)
│   ├── docker-compose.yml
│   ├── .env.example    # Template de variáveis (no git)
│   ├── .env            # Variáveis locais (não rastreado)
│   ├── application_env_docker  # .env da aplicação para Docker
│   ├── data/           # Dados MySQL (não rastreado)
│   └── etc/            # Nginx, PHP, Composer configs
├── install/            # Instalador web
├── updates/            # Scripts SQL de atualização
├── banco.sql           # Schema inicial do banco
├── install.sh          # Script de instalação Linux
├── install.bat         # Script de instalação Windows
└── composer.json       # Dependências PHP
```

## Licença

Veja [LICENSE.txt](LICENSE.txt) para detalhes.
