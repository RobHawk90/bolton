# Makefile for Docker

DIR = 'docker_bolton'

help:
	@echo ""
	@echo "usage: make COMMAND"
	@echo ""
	@echo "Commands:"
	@echo "  build-images       Build images"
	@echo "  rebuild-images     Build images ignoring cache"
	@echo "  start              Create and start containers"
	@echo "  deploy             Start deploy script"
	@echo "  stop               Stop all services"
	@echo "  logs               Follow log output"
	@echo "  php                Open php container"
	@echo "  test               Run tests. It's possible to pass some codeception params"

build-images:
	@cd $(DIR) && docker-compose build

rebuild-images:
	@cd $(DIR) && docker-compose build --no-cache

start:
	@cd $(DIR) && docker-compose up -d

deploy:
	@cd $(DIR) && docker exec -it $(shell cd $(DIR) && docker-compose ps -q php) /bin/sh -c "/var/www/bolton/scripts/deploy.sh $(filter-out $@,$(MAKECMDGOALS))"

stop:
	@cd $(DIR) && docker-compose down -v

logs:
	@cd $(DIR) && docker-compose logs -f

php:
	@cd $(DIR) && docker exec -it -w '/var/www/bolton' $(shell cd $(DIR) && docker-compose ps -q php) bash

db:
	@cd $(DIR) && docker exec -it $(shell cd $(DIR) && docker-compose ps -q db) bash

test:
	@cd $(DIR) && docker exec -u $(id -u):$(id -u) $(shell cd $(DIR) && docker-compose ps -q php) sh -c "cd /var/www/bolton && vendor/bin/phpunit tests/"
