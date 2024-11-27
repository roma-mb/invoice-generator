
### Enviroment:

#### DOCKER

required:
```
Docker:27.1.1
Docker Compose:v2.29.1
```

Env:

```
Copy, env.example and rename to .env
```

Run local folder:
```
  make build
  make up
  make dev
```

*To use 'Make' is required to install it, as Ubuntu OS:*

```
sudo apt update
sudo apt install make
```

*Or use docker commands:*

```
  docker compose build
  docker compose up -d
  composer-install npm-install storage-change storage-permission key-generate db-migrate db-seed
```

#### MANUAL

required:
```JSON
"php": "^8.3",
"composer": "2.7.7"
"node": "20.12.2"
"npm": "10.8.1"
"mysql": "8.0.37"
```

#### Backend:

Composer:

```
php composer.phar install | composer install
```

Env:

```
Copy, env.example and rename to .env
```

Database:
```
CREATE USER admin@localhost IDENTIFIED BY 'admin';
GRANT ALL ON *.* TO admin@localhost;
FLUSH PRIVILEGES;

CREATE DATABASE invoice_generator;
```

Laravel artisan:

```
> php artisan key:generate
> php artisan migrate
> php artisan seed
```

Vue.js:

```
> npm install
```

Up server:

```
> php artisan serve
> npm run dev

http://127.0.0.1:8000/
```

#### Scripts

[phpunit]

```
composer unit
composer unitf
```

PHP CS Fixer

```
composer cs-fixer-dry // Visualizar alterações a serem ajustadas
composer cs-fixer // Ajustar e modificar
```


#### Postman
[Collection](https://elements.getpostman.com/redirect?entityId=6885147-095d972c-765a-4385-936a-ab791fd768ce&entityType=collection)
