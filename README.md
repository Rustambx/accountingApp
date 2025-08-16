# Установка и запуск проекта в Docker
После запуска:
- Сайт доступен: http://localhost

Следуйте этим шагам для локального развертывания проекта.

1. Запустите Docker-контейнеры:
   ```bash
   docker-compose up -d
2. Войдите в контейнер php:
   ```bash
   docker exec -it accounting-php bash

Все команды ниже выполняются внутри контейнера php

3. Установите зависимости composer:
   ```bash
   composer install
4. Создание файла .env на основе .env.example:
   ```bash
   cp .env.example .env
5. Генерация ключа:
   ```bash
   php artisan key:generate
6. Добавить доступы к postgresql в .env:   
   ```
   DB_CONNECTION=pgsql
   DB_HOST=accounting-pgsql
   DB_PORT=5432
   DB_DATABASE=accounting_db
   DB_USERNAME=postgres
   DB_PASSWORD=postgres
   ```
7. Внутри контейнера запустите миграцию:
   ```bash
   php artisan migrate
   ```
