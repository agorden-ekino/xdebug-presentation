# Xdebug-Presentation

## Installation

Install docker and build infra:
`docker-compose up --build --remove-orphans -d`

To start the database container and the dev servers:
`make infra-up`

To run Mysql in command line for development purpose:
`docker-compose exec database mysql -u root --password=password`
