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
# Edite .env se necessário (portas, senhas, etc.)
```

3. Suba os containers (na raiz do projeto):
```bash
docker-compose up -d --build
```

4. Instale as dependências PHP:
```bash
docker-compose run --rm composer install --ignore-platform-reqs --no-scripts
```

5. Acesse o sistema:
   - **Aplicação**: `http://localhost:8000`
   - **phpMyAdmin**: `http://localhost:8080`

6. No primeiro acesso, o instalador será exibido automaticamente. Siga as instruções na tela.

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

---

## Estrutura do Projeto

```
mapos/
├── application/        # Código fonte (CodeIgniter)
├── assets/             # CSS, JS, imagens
├── docker/             # Configurações Docker (etc, data, app_env)
├── install/            # Instalador web e scripts SQL
├── updates/            # (Removido - scripts movidos para install/sql)
├── banco.sql           # Schema inicial do banco
├── docker-compose.yml  # Configuração Docker (raiz)
├── .env.example        # Template de variáveis
└── composer.json       # Dependências PHP
```

## Licença

Veja [LICENSE.txt](LICENSE.txt) para detalhes.
