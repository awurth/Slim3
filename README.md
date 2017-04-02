# Slim-base - Slim 3 skeleton
This is a skeleton for Slim PHP micro-framework to get started quickly

## Features
- Eloquent ORM
- Flash messages
- CSRF protection
- Authentication (Sentinel)
- Validation (Respect)
- Twig templating engine (cache, debug)
- CSS Framework Semantic UI
- Helpers for debugging, assets management, redirections, ...

## Installation
### 1. Create project using Composer
``` bash
$ composer create-project awurth/slim-base [app-name]
```

### 2. Download bower and npm dependencies
``` bash
$ bower install
$ npm install
```
This will create a `lib/` folder in `public/` for jQuery and Semantic UI

##### Install Gulp globally
``` bash
$ npm install -g gulp-cli
```

##### Run watcher to compile SASS and Javascript
``` bash
$ gulp
```

### 3. Setup permissions
You will have to give write permissions to the `cache/` and `cache/twig/` folders
``` bash
$ chmod 777 cache
```

### 4. Create tables
``` bash
$ php bootstrap/database.php
```

## Key files
- `public/index.php`: Application entry point
- `cache/twig/`: Twig cache
- `bootstrap/`: Configuration files
    - `controllers.php`: Registers every controller in the app container
    - `database.php`: Script for creating database tables
    - `parameters.yml.dist`: Database configuration file model (do not put your database configuration here)
    - `dependencies.php`: Services for Pimple
    - `handlers.php`: Slim error handlers
    - `middleware.php`: Application middleware
    - `settings.php`: Application configuration
- `src/`
    - `App/`
        - `Controller/`: Application controllers
            - `Controller.php`: Base controller. All controllers should extend this class
        - `Middleware/`: Application middleware
        - `Model/`: Eloquent model classes
        - `Resources/`
            - `routes/`: Application routes
                - `app.php`: Main routing file
                - `auth.php`: Routing file for authentication
            - `views/`: Twig templates
