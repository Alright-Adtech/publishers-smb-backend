CONTAINER_NAME	:= publishers-smb-backend-app

# targets
.PHONY: default
default: help

## Mostra todos os comandos disponíveis.
.PHONY: help
help:
	@printf "Usage: make [target]\n";

	@awk '{ \
			if ($$0 ~ /^.PHONY: [a-zA-Z\-\_0-9]+$$/) { \
				helpCommand = substr($$0, index($$0, ":") + 2); \
				if (helpMessage) { \
					printf "\033[36m%-20s\033[0m %s\n", \
						helpCommand, helpMessage; \
					helpMessage = ""; \
				} \
			} else if ($$0 ~ /^[a-zA-Z\-\_0-9.]+:/) { \
				helpCommand = substr($$0, 0, index($$0, ":")); \
				if (helpMessage) { \
					printf "\033[36m%-20s\033[0m %s\n", \
						helpCommand, helpMessage; \
					helpMessage = ""; \
				} \
			} else if ($$0 ~ /^##/) { \
				if (helpMessage) { \
					helpMessage = helpMessage"\n                     "substr($$0, 3); \
				} else { \
					helpMessage = substr($$0, 3); \
				} \
			} else { \
				if (helpMessage) { \
					print "\n                     "helpMessage"\n" \
				} \
				helpMessage = ""; \
			} \
		}' \
		$(MAKEFILE_LIST)

## Constrói, (re)cria, inicia e anexa contêineres para um serviço.
.PHONY: up
up:
	@docker-compose up -d

## Constrói, (re)cria, inicia e anexa contêineres para um serviço em produção.
.PHONY: up-prod
up-prod:
	@docker-compose -f ./docker-compose.prod.yml up -d

## Instala todas as dependências no backend e frontend.
.PHONY: install
install:
	@make composer

## Realiza todas as migrações no banco de dados.
.PHONY: migrate
migrate:
	@docker exec -it $(CONTAINER_NAME) php artisan migrate

## Cria as chaves nescessárias.
.PHONY: generate
generate: generate-key
	@docker exec -it $(CONTAINER_NAME) php artisan passport:client --personal --name=smb_front

generate-key:
	@docker exec -it $(CONTAINER_NAME) php artisan key:generate

## Interrompe e remove contêineres, redes, volumes e imagens criadas por up.
.PHONY: stop
stop:
	@docker-compose down

## Interrompe e remove contêineres, redes, volumes e imagens criadas por up em produção.
.PHONY: stop-prod
stop-prod:
	@docker-compose -f ./docker-compose.prod.yml down

## Mostrar registros de contêiner da aplicação (app).
.PHONY: logs
logs:
	@docker container logs $(CONTAINER_NAME) --follow

## Interaja dentro do contêiner da aplicação (app).
.PHONY: terminal
terminal:
	@  $(CONTAINER_NAME) sh

## Inspecione o contêiner da aplicação (app).
.PHONY: inspect
inspect:
	@docker container inspect $(CONTAINER_NAME)

## Instala as dependências do backend.
.PHONY: composer
composer:
	docker run --rm --interactive --tty \
      --volume ${PWD}:/app \
      --user ${CURRENT_UID}:${CURRENT_GID} \
      composer install


