Для разворачивания проекта понадобится docker и docker-compose

1) docker-compose up -d
2) docker-compose exec php composer install
3) docker-compose exec php php yii migrate

PUT  http://localhost:8080/cryptocurrencies/update
GET  http://localhost:8080/cryptocurrencies/NIS
POST http://localhost:8080/cryptocurrencies/calculate
GET  http://localhost:8080/cryptocurrencies (Поддерживает limit, offset)
