# Xdebug-Presentation

## Project Installation

Install docker and build infra:

```shell
docker-compose up --build --remove-orphans -d
```

```shell
composer install
yarn install
```

To start the database container and the dev servers:

```shell
make infra-up
```

To run Mysql in command line for development purpose:

```shell
docker-compose exec database mysql -u root --password=password
```

## Xdebug

### Install
