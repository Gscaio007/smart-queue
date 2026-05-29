# Landing Smart - SmartQueue

O **SmartQueue** é um ecossistema full-stack desenvolvido para o monitoramento e exibição de filas de atendimento em tempo real, integrado à esteira de disparos assíncronos da **Landing Smart**. 

O projeto simula um cenário real de alta demanda, onde os processos de background (como o envio automatizado de e-mails em massa através do `ProcessCampaignJob`) são enfileirados no Redis pelo back-end e gerenciados visualmente por um painel administrativo moderno de alta performance.

---

## Demonstração do Layout

<p align="center">
  <img src="./smartqueue-front/src/assets/SmartQueueEmails - LS.png" alt="Dashboard SmartQueue" width="100%">
</p>

---

## Arquitetura e Tecnologias

A aplicação foi desenhada separando estritamente as responsabilidades de cliente e servidor:

### 💻 Front-end (`landing-smart-queue-front`)
* **React + TypeScript:** Componentização tipada, garantindo robustez e prevenção de erros em tempo de compilação.
* **Tailwind CSS:** Layout modular em estilo Dashboard/SaaS, focado em alta legibilidade com Dark Mode nativo.
* **Lucide React:** Conjunto de ícones minimalistas para interface administrativa.
* **TanStack Query (React Query) / LocalStorage:** Camada otimizada para gerenciamento de estado e cache de dados.

### ⚙️ Back-end (`landing-smart-queue-back`)
* **Laravel (PHP):** Construção de API robusta para gerenciamento das regras de negócio e despacho de eventos.
* **Laravel Queues & Jobs:** Processamento assíncrono em background isolando tarefas pesadas (envio de campanhas de e-mail).
* **Redis:** Driver de cache e mensageria em memória de ultra-baixa latência para controle rigoroso da fila de execução.

---

## Como Executar o Projeto Localmente

### Pré-requisitos
* Node.js (v18+)
* PHP (v8.1+) & Composer
* Servidor Redis ativo (via Docker ou local)

### 1. Configurando o Back-end (Laravel)
```bash
# Clone o repositório do back-end
cd landing-smart-queue-back

# Instale as dependências
composer install

# Configure o ambiente (.env)
cp .env.example .env
php artisan key:generate

# Inicie o servidor da API
php artisan serve

# Execute o worker para processar as filas do Redis
php artisan queue:work

#---- Frontend p/ consumo da API ---------

# Clone o repositório do front-end
cd landing-smart-queue-front

# Instale as dependências
npm install

# Inicie o servidor de desenvolvimento
npm run dev
