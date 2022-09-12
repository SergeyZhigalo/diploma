# Информационная система для учреждения дополнительного образования

## Описание

Разработка информационной системы для учреждения дополнительного образования велась в рамках создания выпускной квалификационной работы.

Работа над проектом велась в 2021 году. В проекте использовались следующие технологии:

- HTML
- CSS
- JavaScript
- PHP
- MySQL

Для работы с пользовательским интерфейсом использовалась библиотека [jQuery](https://jquery.com).

Для создания галереи использовалась библиотека [Fancybox](https://fancyapps.com/docs/ui/fancybox/).

Для масок ввода использовался плагин [jquery.maskedinput](https://www.npmjs.com/package/jquery.maskedinput).

## Описание проекта

Работа с информационной системой возможна без авторизации, однако часть функций доступна только авторизованным пользователям.

Существует два типа пользователей: пользователь и администратор.

Функционал незарегистрированного пользователя:
- просмотр информации на сайте
- просмотр доступных курсов
- просмотр статей
- регистрация и авторизация

Функционал зарегистрированного пользователя:
- возможность записи на курсы
- доступ к личному кабинету
- просмотр курсов, на которые записан пользователь
- изменение личных данных

Функционал администратора:
- доступ к панели администратора
- доступ к краткой статистике
- добавление, редактирование и удаление курсов
- добавление, редактирование и удаление статей
- редактирование записей на курсы

## Описание реализуемых функций

### Регистрация
- имя (обязательное поле)
- телефон (обязательное поле, маска ввода, уникальное поле)
- email (обязательное поле, уникальное поле)
- пароль (обязательное поле)
- подтверждение пароля (обязательное поле)

### Авторизация
- email (обязательное поле)
- пароль (обязательное поле)

### Изменение личных данных
- имя (обязательное поле)
- телефон (обязательное поле, маска ввода)
- email (обязательное поле)

### Добавление статьи
- название (обязательное поле)
- дата (обязательное поле)
- краткое описание
- текст
- превью изображение
- изображение

### Редактирование статьи

Редактирование статьи происходит аналогично добавлению статьи, за исключением того, что в форме редактирования отображаются данные о статье, которую необходимо отредактировать.

### Удаление статьи

Удаление кадра происходит через ввод проверочной фразы.

### Добавление курса
- название (обязательное поле)
- логотип (обязательное поле)
- краткое описание (обязательное поле)
- количество участников (обязательное поле, число от 1)

### Редактирование курса

Редактирование курса происходит аналогично добавлению курса, за исключением того, что в форме редактирования отображаются данные о курсе, которые необходимо отредактировать.

### Удаление курса

Удаление кадра происходит через ввод проверочной фразы.