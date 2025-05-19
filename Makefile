# ======================
# Project Initialization
# ======================

init: ## Инициализировать проект (полная настройка)
	@cp -n .env.example .env && chmod 666 .env || echo "⚠️  .env уже существует, пропускаем..."
	@make up
	@make composer-install
	@make npm-install
	@make key-generate
	@make migrate
	@make composer-dev


# ======================
# Docker Commands
# ======================

.PHONY: up down build restart bash

up: ## Запустить контейнеры
	docker-compose up -d

down: ## Остановить контейнеры
	docker-compose down

build: ## Пересобрать контейнеры
	docker-compose build

restart: ## Перезапустить контейнеры
	docker-compose restart

bash: ## Войти в контейнер с приложением (аналог docker exec -it balances_app bash)
	docker-compose exec app bash


# ======================
# Application Setup
# ======================

key-generate: ## Сгенерировать ключ приложения
	docker-compose exec app php artisan key:generate

# ======================
# Frontend Commands
# ======================

npm-install: ## Установить npm зависимости
	docker-compose exec app npm install

npm-build: ## Собрать фронтенд для production
	docker-compose exec app npm run build


# ======================
# Backend Commands
# ======================

composer-install: ## Установить composer зависимости
	docker-compose exec app composer install

composer-dev: ## Запустить dev-сборку (аналог composer run dev)
	docker-compose exec app composer run dev

# ======================
# Database Commands
# ======================

migrate: ## Запустить миграции
	docker-compose exec app php artisan migrate

migrate-fresh: ## Сбросить и запустить миграции заново
	docker-compose exec app php artisan migrate:fresh


# ======================
# Help
# ======================

help: ## Показать доступные команды
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
