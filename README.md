## Для работы с проектом необходимо выполнить следующее:
### Собрать docker образ: 
docker-compose build
### Запустить контейнеры: 
docker-compose up -d
### Установка зависимостей: 
docker-compose exec php composer install
### Применить миграции БД: 
docker-compose exec php /vendor/bin/phinx migrate
### Занести данные в таблицу ролей: 
docker-compose exec php /vendor/bin/phinx seed:run

#### Спецификация openApi находится в файле /project/api.yaml
