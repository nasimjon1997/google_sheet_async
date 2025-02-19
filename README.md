# Инструкция по установке и настройке проекта с интеграцией Google Sheets

Этот проект позволяет интегрировать Google Sheets в приложение Laravel для удобного хранения данных в Google Sheets.

## 1. Клонирование репозитория

Скачайте репозиторий:

```bash
git clone https://github.com/nasimjon1997/google_sheet_async
cd google_sheet_async
```

## 2. Установка зависимостей

Установите зависимости:

```bash
composer install
```


## 3. Настройка переменных окружения

Создайте файл .env, если его еще нет и укажите настройки бд : 

```bash
cp .env.example .env

```

## 4. Миграции таблиц БД

 Миграции таблиц БД : 

```bash
php artisan migrate

```

## 5.Настройка crontab

 Добавьте следующую строку в файл crontab, чтобы запустить Laravel планировщик каждую минуту:

```bash
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

## 5.Запуск проекта

Теперь можно запустить сервер:
    
```bash
php artisan serve
```






