## Для работы с проектом необходимо выполнить следующее:
### Собрать docker образ: 
docker-compose build
### Создать контейнеры: 
docker-compose up -d
### Создать папку vendor и обновить зависимости: 
docker-compose exec php composer update
### Создать таблицы базы данных: 
docker-compose exec php /vendor/bin/phinx migrate
### Занести данные в таблицу ролей: 
docker-compose exec php /vendor/bin/phinx seed:run

#### Спецификация openApi находится в файле /project/api.yaml
