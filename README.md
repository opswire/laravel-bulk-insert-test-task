# laravel-bulk-insert-test-task

### Задание: [Тестовое задание, вакансия PHP-fullstack разработчик.pdf](%D2%E5%F1%F2%EE%E2%EE%E5%20%E7%E0%E4%E0%ED%E8%E5%2C%20%E2%E0%EA%E0%ED%F1%E8%FF%20PHP-fullstack%20%F0%E0%E7%F0%E0%E1%EE%F2%F7%E8%EA.pdf)

## Preview ![preview.png](preview.png)

``
Stack: Laravel, mysql
``

## Инструкция По Запуску:


+ ``` Clone the repo```


+ ``` cd laravel-bulk-insert-test-task```


+ ```cp .env.example .env```


+ ```docker-compose up --build -d```


+ ```docker-compose run --rm -it app composer install```


+ ```docker-compose run --rm -it app php artisan migrate```

#### Сервер доступен на 8000 порту

#### Для проверки производительности использовать эндпоинт http://localhost:8000/telescope/requests




