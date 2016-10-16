# Quick slim - Slim 3 skeleton
This is a skeleton for Slim PHP micro-framework to get started quickly

# Features
- Eloquent ORM
- Flash messages
- Twig templating engine
- Twig cache
- Twig debug extension

# Installation
## Create project
### Using composer
```
$ composer create-project awurth/quickslim [app-name]
```

### Manual install
```
$ git clone https://github.com/awurth/quickslim.git
$ composer install
```

## Setup permissions
```
$ cd [app-name]
$ chmod 777 cache
```

## Configure database connection
Navigate to the `bootstrap/` folder and copy `db.php.dist` to `db.php`
```
$ cd bootstrap
$ cp db.php.dist db.php
```

Now you can edit db.php and add your database configuration

# Key directories
- `bootstrap`: Configuration files
- `cache`: Twig cache
- `public`: Public resources accessible from a web browser
- `src`: Application source code
- `src/App/Controller`: Application controllers
- `src/App/Model`: Eloquent model classes
- `src/App/Resources/routes`: Application routes
- `src/App/Resources/views`: Twig templates

# Key files
- `public/index.php`: Application entry point
- `bootstrap/controllers.php`: Registers every controller in the app container
- `bootstrap/db.php.dist`: Database configuration file model (do not put your database configuration here)
- `bootstrap/dependencies.php`: Services for Pimple
- `boostrap/routes.php`: Includes all routing files
- `bootstrap/settings`: Application configuration
- `src/App/Controller/Controller.php`: Base controller. All controllers should extend this class
- `src/App/Resources/routes/app.php`: Main routing file

## TODO
- Middlewares
- Authentication
- Validation
