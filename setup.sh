#!/bin/bash

echo "Iniciando o setup do projeto Laravel com Vue + Vite..."

set -e

if ! command -v composer &> /dev/null
then
    echo "Composer não encontrado. Instale o Composer antes de continuar."
    exit 1
fi

if ! command -v npm &> /dev/null
then
    echo "npm não encontrado. Instale o Node.js e o npm antes de continuar."
    exit 1
fi

echo "Instalando dependências PHP..."
composer install

echo "Instalando dependências Node..."
npm install

echo "Copiando .env..."
cp -n .env.example .env

echo "Gerando chave da aplicação..."
php artisan key:generate

echo "Criando banco SQLite (se necessário)..."
touch database/database.sqlite

echo "Rodando migrations..."
php artisan migrate

echo "Build inicial do front-end (Vite)..."
npm run build

echo "Setup concluído com sucesso!"
echo "Agora você pode rodar o projeto com: npm run dev OU composer run dev"
