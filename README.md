# Cinema-online

Приложение где пользователи могут просматривать фильмы, ставить к ним оценки и оставлять рецензии.

## Установка

1. Клонируйте репозиторий:
    ```bash
    git clone https://github.com/KonstantinKliman/Cinema-online.git
    ```

2. Перейдите в директорию проекта:
    ```bash
    cd Cinema-online
    ```
   
3. Создайте файл `.env` из примера и настройте его:
    ```bash
    cp .env.example .env
    ```

4. Сбилдите и поднимите docker-контейнеры
    ```bash
    docker-compose up --build -d
    ```

5. После того, как контейнеры будут запущены, зайдите в командную строку `bash` контейнера `cinema-online-php`
    ```bash
    docker exec -it cinema-online-php bash
    ```

6. Сгенерируйте ключ приложения:
    ```bash
    php artisan key:generate
    ```

7. Выполните миграции базы данных. Ключ `--seed` нужен для внесения в бд тестовых данных:
    ```bash
    php artisan migrate --seed
    ```
   
8. Создайте ссылку к локальному хранилищу:
    ```bash
    php artisan storage:link
    ```
