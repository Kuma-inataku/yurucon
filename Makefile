# Define the Docker Compose command
DOCKER_COMPOSE := docker-compose

# build
.PHONY: build
build:
	$(DOCKER_COMPOSE) build

# up
.PHONY: up
up:
	$(DOCKER_COMPOSE) up -d

# buuld & up
.PHONY: create
create:
	$(DOCKER_COMPOSE) up -d --build

# down
.PHONY: down
down:
	$(DOCKER_COMPOSE) down

# totally down
.PHONY: clean
clean:
	$(DOCKER_COMPOSE) down --volumes --remove-orphans

# bash app container
.PHONY: app
app:
	$(DOCKER_COMPOSE) exec app bash

# bash mysql container
.PHONY: mysql
mysql:
	$(DOCKER_COMPOSE) exec mysql bash
