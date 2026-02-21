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

3. Suba os containers:
```bash
docker-compose up -d --build
```

4. Acesse o sistema:
   - **Aplicação**: `http://localhost:8000`
   - **phpMyAdmin**: `http://localhost:8080`

5. No primeiro acesso, o instalador será exibido automaticamente. Siga as instruções na tela.

---

## Estrutura do Projeto

A versão atual foi limpa para focar apenas nos arquivos essenciais de execução e instalação.

```
mapos/
├── application/        # Código fonte PHP (CodeIgniter)
├── assets/             # Assets (CSS, JS, Imagens)
├── docker/             # Configurações do ambiente Docker (etc, data)
├── install/            # Instalador WEB e scripts SQL
├── banco.sql           # Schema inicial do banco de dados
├── docker-compose.yml  # Configuração central do Docker
├── .env.example        # Modelo de variáveis de ambiente
└── composer.json       # Gerenciador de dependências PHP
```

## Licença

Este projeto é software livre sob a licença [MIT](LICENSE.txt).
