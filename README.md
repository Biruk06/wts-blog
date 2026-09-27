
# Бэкенд для мобильного приложения "Блог" с REST API и административной панелью на Orchid.

##  Быстрый запуск проекта

Проект разворачивается в Docker с помощью **Laravel Sail**.

### 1. Клонировать репозиторий и перейти в папку
```bash
git clone https://github.com/Biruk06/wts-blog
cd wts-blog
```

### 2. Скопировать файл окружения

```
cp .env.example .env
```

### 3\. Установить зависимости и запустить Docker

```
# Установка Composer-зависимостей без локального PHP
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

# Запуск контейнеров в фоновом режиме
./vendor/bin/sail up -d
```

### 4\. Настроить базу данных и создать админа

```
# Генерация ключа приложения
./vendor/bin/sail artisan key:generate

# Запуск миграций и создание начальных данных
./vendor/bin/sail artisan migrate --seed

# Создание суперпользователя для админ-панели Orchid
./vendor/bin/sail artisan orchid:admin

```

---

### 📌 Адреса сервисов:

* **Админ-панель Orchid:** `http://localhost/admin`
* **Базовый URL REST API:** `http://localhost/api`

### Основные API Эндпоинты:

* `POST /api/register` — Регистрация пользователя
* `POST /api/login` — Авторизация и получение Bearer токена
* `POST /api/logout` — Выход из системы (требует токен)
* `GET /api/posts` — Общая лента публикаций (пагинация `limit`/`offset`, сортировка, фильтр дат)
* `GET /api/my-posts` — Публикации текущего авторизованного пользователя
* `POST /api/posts` — Создание публикации (требует токен)
* `DELETE /api/posts/{id}` — Мягкое удаление публикации (Soft Delete)