# 🎰 KingPanda BET - Sistema de Gerenciamento de Apostas

[![PHP](https://img.shields.io/badge/PHP-8.1+-blue.svg)](https://www.php.net)
[![Docker](https://img.shields.io/badge/Docker-Ready-green.svg)](https://www.docker.com)
[![Tests](https://img.shields.io/badge/Tests-58%20passing-success.svg)](tests/)
[![OpenAPI](https://img.shields.io/badge/OpenAPI-3.0-orange.svg)](public/docs/openapi.json)

Sistema de gerenciamento de apostas esportivas desenvolvido para demonstração técnica, utilizando PHP REST Reference Architecture com Clean Architecture e Domain-Driven Design.

## 📋 Visão Geral

Este projeto demonstra a implementação profissional de uma API REST para sistema de apostas, desenvolvido seguindo as melhores práticas de arquitetura e desenvolvimento.

### 🚀 Tecnologias Utilizadas

- **Framework**: [PHP REST Reference Architecture](https://github.com/byjg/php-rest-reference-architecture) (byjg)
- **Linguagem**: PHP 8.1+
- **Banco de Dados**: MySQL 8.0
- **Containerização**: Docker & Docker Compose
- **Autenticação**: JWT com roles (user/admin)
- **Testes**: PHPUnit (58 testes automatizados)
- **Documentação**: OpenAPI 3.0 / Swagger UI
- **Versionamento**: Git Flow + Conventional Commits

## 🏗️ Arquitetura

O projeto segue Clean Architecture com separação clara de responsabilidades:

```
src/
├── Model/          # Entidades de domínio
├── Repository/     # Camada de acesso a dados
├── Rest/           # Controllers REST
└── Util/           # Utilitários e helpers

db/
├── migrations/     # Versionamento do banco
│   ├── up/        # Aplicar mudanças
│   └── down/      # Reverter mudanças

tests/
└── Rest/          # Testes de integração
```

## 🎲 Funcionalidades Implementadas

### Sistema de Apostas Completo

#### 1. **Gerenciamento de Cotações (bet_odds)**
- CRUD completo de cotações
- Filtro de cotações ativas
- Suspensão de cotações (admin)

#### 2. **Gerenciamento de Apostas (bets)**
- CRUD completo de apostas
- Visualização de apostas do usuário
- Histórico personalizado

#### 3. **Endpoints Customizados**
Além do CRUD básico gerado automaticamente, foram implementados:
- `GET /bet/odds/active` - Lista apenas cotações ativas
- `PUT /bet/odds/{id}/suspend` - Suspende uma cotação (admin)
- `GET /my/bets` - Lista apostas do usuário autenticado

## 🚀 Como Executar

### Pré-requisitos
- Docker Desktop 28.x+ e Docker Compose v2.x+
- PHP 8.1+ e Composer 2.x+ (para instalar dependências)
- Git para clonar o repositório

### 1. Clone o repositório
```bash
git clone https://github.com/rafael-nery/king-panda-technical-interview.git
cd king-panda-technical-interview
```

### 2. Instale as dependências do projeto
```bash
composer install
```

### 3. Inicie os containers Docker com build
```bash
docker compose -f docker-compose-dev.yml up -d --build
```
**Nota**: Se houver problemas de autenticação com Docker Hub, faça login no Docker Desktop primeiro.

### 4. Execute as migrations
```bash
docker compose -f docker-compose-dev.yml exec rest composer run migrate -- reset --yes
```

### 5. (Opcional) Popule o banco com dados de teste
```bash
# Inserir cotações de apostas
docker compose -f docker-compose-dev.yml exec mysql-container mysql -uroot -pmysqlp455w0rd mydb -e "
INSERT INTO bet_odds (event_name, event_date, market_type, selection, odds, status) VALUES
('Flamengo vs Palmeiras - Brasileirão', '2025-09-28 16:00:00', 'Resultado Final', 'Flamengo', 2.10, 'active'),
('Flamengo vs Palmeiras - Brasileirão', '2025-09-28 16:00:00', 'Resultado Final', 'Empate', 3.20, 'active'),
('Real Madrid vs Barcelona - La Liga', '2025-09-29 11:00:00', 'Resultado Final', 'Real Madrid', 2.25, 'active');"

# Inserir apostas de exemplo para o usuário comum
docker compose -f docker-compose-dev.yml exec mysql-container mysql -uroot -pmysqlp455w0rd mydb -e "
INSERT INTO bets (user_id, bet_odds_id, stake, potential_return, status, placed_at) VALUES
(UNHEX('5F6E7FE7BD1B11ED8CA90242AC120002'), 1, 100.00, 210.00, 'pending', NOW());"
```

### 6. Teste a API
```bash
# Verificar se está funcionando
curl http://localhost:8080/sample/ping
# Resposta esperada: {"result":"pong"}
```

### 7. Execute os testes automatizados
```bash
docker compose -f docker-compose-dev.yml exec rest composer run test
```

### 8. Acesse a aplicação
- **API**: http://localhost:8080
- **Documentação Swagger**: http://localhost:8080/docs

## 📡 Endpoints Principais

### Autenticação

**Usuários padrão criados pelas migrations:**
- **Admin**: admin@example.com / !P4ssw0rdstr!
- **User comum**: user@example.com / !P4ssw0rdstr!

```http
POST /login
{
  "username": "admin@example.com",
  "password": "!P4ssw0rdstr!"
}
```

### Cotações (BetOdds)
| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| GET | `/bet/odds` | Lista todas cotações | ✅ |
| GET | `/bet/odds/{id}` | Busca cotação por ID | ✅ |
| GET | `/bet/odds/active` | Lista cotações ativas | ✅ |
| POST | `/bet/odds` | Cria nova cotação | Admin |
| PUT | `/bet/odds` | Atualiza cotação | Admin |
| PUT | `/bet/odds/{id}/suspend` | Suspende cotação | Admin |
| DELETE | `/bet/odds/{id}` | Remove cotação | Admin |

### Apostas (Bets)
| Método | Endpoint | Descrição | Autenticação |
|--------|----------|-----------|--------------|
| GET | `/bets` | Lista todas apostas | ✅ |
| GET | `/bets/{id}` | Busca aposta por ID | ✅ |
| GET | `/my/bets` | Minhas apostas | ✅ |
| POST | `/bets` | Cria nova aposta | Admin |
| PUT | `/bets` | Atualiza aposta | Admin |
| DELETE | `/bets/{id}` | Remove aposta | Admin |

## 🧪 Testes

O projeto possui **58 testes automatizados** cobrindo:
- ✅ Autenticação e autorização
- ✅ CRUD completo de todas entidades
- ✅ Endpoints customizados
- ✅ Validações e regras de negócio
- ✅ Tratamento de erros

Para executar os testes:
```bash
docker-compose -f docker-compose-dev.yml exec rest composer run test
```

## 📈 Estrutura do Banco de Dados

### Acesso ao MySQL
```bash
# Via Docker
docker compose -f docker-compose-dev.yml exec mysql-container mysql -uroot -pmysqlp455w0rd mydb

# Conexão direta
Host: localhost
Port: 3306
Database: mydb
User: root
Password: mysqlp455w0rd
```

### Tabela `bet_odds`
```sql
- id (INT, PK)
- event_name (VARCHAR 255)
- event_date (DATETIME)
- market_type (VARCHAR 50)
- selection (VARCHAR 100)
- odds (DECIMAL 10,2)
- status (VARCHAR 20)
- created_at (DATETIME)
- updated_at (DATETIME)
```

### Tabela `bets`
```sql
- id (INT, PK)
- user_id (BINARY 16, FK)
- bet_odds_id (INT, FK)
- stake (DECIMAL 10,2)
- potential_return (DECIMAL 10,2)
- status (VARCHAR 20)
- placed_at (DATETIME)
- settled_at (DATETIME)
```

## 🔧 Scripts Disponíveis

```bash
# Executar testes
composer run test

# Executar migrations
composer run migrate

# Resetar banco
composer run migrate -- reset

# Gerar documentação OpenAPI
composer run openapi

# Gerar código (CRUD)
composer run codegen
```

## 📚 Desenvolvimento

### Processo de Desenvolvimento Seguido

1. **Setup Inicial**: Configuração do ambiente Docker e estrutura base
2. **Tutorial Completo**: Seguindo TUTORIAL_IMPLEMENTATION.md
3. **Implementação do Sistema de Apostas**:
   - Migrations para criação das tabelas
   - Geração de CRUD com codegen
   - Implementação de endpoints customizados
   - Testes automatizados
   - Documentação OpenAPI

### Git Flow Utilizado

```
main
 └── develop
      ├── feature/example-crud-table
      ├── feature/add-status-field
      ├── feature/custom-status-endpoint
      ├── feature/bet-odds-tables
      └── feature/custom-betting-endpoints
```

### Conventional Commits

Todos os commits seguem o padrão:
- `feat:` Nova funcionalidade
- `fix:` Correção de bug
- `docs:` Documentação
- `test:` Testes
- `chore:` Tarefas de manutenção

## 🎯 Diferenciais Técnicos Implementados

- ✅ **Clean Architecture**: Separação clara de responsabilidades
- ✅ **Database Migrations**: Versionamento completo do banco
- ✅ **Code Generation**: Produtividade com codegen para CRUD básico
- ✅ **Endpoints Customizados**: Além do CRUD automático
- ✅ **Testes Automatizados**: 58 testes cobrindo toda aplicação
- ✅ **Documentação OpenAPI**: Swagger completo e atualizado
- ✅ **Docker Environment**: Ambiente containerizado
- ✅ **Git Best Practices**: Conventional Commits e Git Flow
- ✅ **JWT Authentication**: Com roles (user/admin)
- ✅ **RESTful Design**: Seguindo princípios REST

## 👨‍💻 Autor

**Rafael Nery**
- GitHub: [@rafael-nery](https://github.com/rafael-nery)
- Projeto: Entrevista Técnica KingPanda BET
- Data: Setembro 2025

## 📝 Licença

Este projeto foi desenvolvido como parte de um processo seletivo técnico.

---

💡 **Nota**: Este projeto demonstra proficiência em PHP REST development, Clean Architecture, testes automatizados e boas práticas de desenvolvimento.