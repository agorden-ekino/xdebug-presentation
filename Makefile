.PHONY: app-about app-install composer-validate dependencies-security-check infra-up infra-stop server-start server-status server-stop help

# Parameters
SHELL := /bin/bash

# Executables
BIN_CONSOLE = php bin/console
COMPOSER = composer
DOCKER_COMPOSE = docker-compose
DOCKER_MACHINE = docker-machine
SYMFONY = symfony
YARN = yarn

app-about: ## about environment
	$(BIN_CONSOLE) about
	$(BIN_CONSOLE) debug:dotenv

#app-install: ## install dependencies, create database, load migrations, fixtures, start servers
#	$(BIN_CONSOLE) doctrine:database:create --if-not-exists
#	if (shopt -s nullglob; migrations=(migrations/*); ((! $${#migrations[@]}))); then \
#		echo "The migrations directory is empty : generating migration file"; \
#		$(BIN_CONSOLE) make:migration; \
#	else \
#		echo "Migration files already exist."; \
#	fi;
#	$(BIN_CONSOLE) doctrine:migrations:migrate
#	$(BIN_CONSOLE) doctrine:fixtures:load
#	$(COMPOSER) install
#	$(YARN) install

composer-validate: ## validate composer config
	$(COMPOSER) validate --no-check-publish

dependencies-security-check: ## check dependencies security vulnerabilities
	$(SYMFONY) check:security

infra-up:
	docker-machine start local-docker
	eval $$(docker-machine env local-docker)
	$(DOCKER_COMPOSE) up -d
	@make server-start

infra-stop:
	@make server-stop
	$(DOCKER_COMPOSE) stop
	$(DOCKER_MACHINE) stop local-docker

server-start: ## start development servers
	$(SYMFONY) server:start -d
	$(SYMFONY) run -d yarn encore dev-server

server-status: ## show development server status
	$(SYMFONY) server:status

server-stop: ## stop development servers
	$(SYMFONY) server:stop

help: ## list all available make commands for this project
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-10s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'