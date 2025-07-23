# 🚀 Project manager

Sistema de gerenciador de projetos.

---

## 📦 Tecnologias Utilizadas

- Laravel 12
- Vue 3 + Composition API
- Inertia.js
- Vite
- TailwindCSS
- Ziggy (rotas frontend)
- SweetAlert2 (notificações)
- Spatie Laravel Permission (controle de permissões)

---

## ⚙️ Requisitos

Antes de iniciar, certifique-se de ter instalado:

- PHP >= 8.2
- Composer
- Node.js >= 18
- SQLite (ou outro banco compatível)
- Git

---

## 🚀 Instalação Rápida

**Em seu terminal!**

### 1. Clone o projeto

git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio

### 2. Execute o script de setup automático

chmod +x setup.sh
./setup.sh

**Esse script irá:**

- Instalar dependências PHP e JS
- Copiar .env.example para .env
- Gerar a chave da aplicação
- Criar o banco SQLite
- Rodar as migrations
- Fazer o build inicial do front-end

---

## 🧪 Rodando em Desenvolvimento

**Comando simplificado**

composer run dev

**Ou manualmente**

php artisan serve
npm run dev

---

## TESTES

php artisan test