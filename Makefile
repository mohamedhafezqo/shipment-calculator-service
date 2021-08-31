up:
	docker-compose up --build -d
	docker exec php-container composer install

down:
	docker-compose down

shipment-discount-calculate:
	docker exec php-container bin/console shipment-discount:calculate

test:
	docker exec php-container php bin/phpunit

bash:
	docker exec -it php-container  bash