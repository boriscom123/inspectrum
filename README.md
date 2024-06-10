# Inspectrum-Clinic

## https://inspectrum.clinic/

## Сборка Laravel 10 + Vue.js 3

## Документация Laravel

### https://laravel.com/docs/10.x

## Документация Vue.js

### https://vuejs.org/guide/introduction.html

### Установка и сборка проекта:

1. На локальном ПК должны быть установлен минимальный список ПО
- git https://git-scm.com/
- docker https://www.docker.com/

2. Получаем доступ к репозиторию GitLab

3. Необходимо сгенерировать ED25519 SSH ключ на локальном ПК
- Команда: 'ssh-keygen -t ed25519'
- Утилита попросит вас указать пароль для защиты закрытого ключа. Если вы укажете пароль, то каждый раз при использовании этого ключа для SSH авторизации, вы должны будете вводить этот пароль. Можно оставить поле пустым.
- Также при создании на экран будет выведен путь до расположения ключа.

4. Добавление SSH ключа в gitlab
- Зайти в раздел Пользователь - Edit profile - SSH Keys
- в поле SSH Fingerprints добавить содержимое публичного ключа. Например id_ed25519.pub.
- Сохранить ключ.

5. Добавить сайт gitlab.com в список известных хостов (known_hosts)
- на локальном ПК в папке с SSH ключами в файл known_hosts добавить запись типа:
'github.com ssh-ed25519 AAAAC3NzaC1lZDI1NTE5AAAAIA/1+cZz3Ad4GE9nFkwNYAnCtK58C+HcrnimNkGXyq4y user@DESKTOP' используя данные Вашего публичного ключа.

6. Клонируем репозиторий Inspectrum-Clinic по SSH
- Команда: 'sudo git clone git@gitlab.com:inspectrum-web/inspectrum-clinic.git inspectrum'

7. Переходим в папку с проектом
- Команда: 'cd inspectrum'

8. Создаем файл с настройками проекта .env на основе .env.example
- Команда: 'cp .env.example .env'

9. Создаем Docker Containers с проектом который автоматически запуститься после сборки
- Команда: 'sudo docker-compose up --build'

10. Обновляем зависимости пакетов php
- Команда: 'sudo docker-compose run --rm php composer update'

11. Добавляем необходимые права для некоторых папок
- Команда: 'sudo chmod 777 /home/www/inspectrum/app/public'
- Команда: 'sudo chmod 777 /home/www/inspectrum/app/storage/framework/cache'
- Команда: 'sudo chmod 777 /home/www/inspectrum/app/storage/framework/sessions'
- Команда: 'sudo chmod 777 /home/www/inspectrum/app/storage/framework/views'

12. Обновляем зависимости пакетов js
- Команда: 'sudo docker-compose run --rm node npm i'

13. Сборка фронт-части Vue.js
- Команда: 'sudo docker-compose run --rm node npm run build'

14. Восстанавливаем данные БД из дампа - по отдельной инструкции
- Команда: 'sudo docker-compose run --rm php php artisan migrate'
- Команда:  docker exec InspectrumClinic-mysql sh -c 'exec mysqldump --all-databases -u root -p super_password_admin_root > /dumps/mydump.sql'
- Команда:  'docker exec -t -i InspectrumClinic-php /bin/bash'

15. Проверяем доступность локального сайта localhost


