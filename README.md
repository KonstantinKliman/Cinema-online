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

3. Установите зависимости:
    ```bash
    composer install
    ```

4. Создайте файл `.env` из примера и настройте его:
    ```bash
    cp .env.example .env
    ```

5. Сгенерируйте ключ приложения:
    ```bash
    php artisan key:generate
    ```

6. Выполните миграции базы данных. Ключ `--seed` нужен для внесения в бд тестовых данные:
    ```bash
    php artisan migrate
    ```
   
7. Создайте ссылку к локальному хранилищу:
    ```bash
    php artisan storage:link
    ```

8. Запустите локальный сервер:
    ```bash
    php artisan serve --seed
    ```
