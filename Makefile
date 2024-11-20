FIG=docker-compose
HAS_DOCKER:=$(shell command -v $(FIG) 2> /dev/null)


ifdef HAS_DOCKER
  EXEC=$(FIG) exec app
  EXEC_DB=$(FIG) exec db
else
  EXEC=
  EXEC_DB=
endif


# Symfony command
CONSOLE=php bin/console


check:
	$(EXEC) composer check

csfix:
	$(EXEC) composer fix


docker.up:
	docker-compose up

docker.up.demon:
	docker-compose up -d

docker.down:
	docker-compose down

docker.start:
	docker-compose start

docker.start.demon:
	docker-compose start.demon

docker.stop:
	docker-compose stop

docker.restart: stop start.demon


update:
	$(EXEC) composer install

upgrade:
	$(EXEC) composer update

entity:
	$(EXEC) $(CONSOLE) make:entity

migration:
	$(EXEC) $(CONSOLE) make:migration

migrate:
	$(EXEC) $(CONSOLE) doctrine:migration:migrate

migration.list:
	$(EXEC) $(CONSOLE) doctrine:migration:list