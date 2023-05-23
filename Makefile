.PHONY: up down

up:
	docker-compose -f ./app/docker-compose.dev.yml up -d --remove-orphans

down:
	docker-compose -f ./app/docker-compose.dev.yml down --remove-orphans
