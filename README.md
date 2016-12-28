# Quick slim - Slim 3 skeleton
This is a skeleton for Slim PHP micro-framework to get started quickly

## Features
- Eloquent ORM
- Flash messages
- CSRF protection
- Authentication (Sentinel)
- Validation (Respect)
- Twig templating engine
- Twig cache
- Twig debug extension

## Installation
### 1. Create project
#### Using composer
```bash
$ composer create-project awurth/quickslim [app-name]
```

#### Manual install
```bash
$ git clone https://github.com/awurth/quickslim.git
$ composer install
```

### 2. Setup permissions
```bash
$ cd [app-name]
$ chmod 777 cache
```

### 3. Configure database connection
Navigate to the `bootstrap/` folder and copy `db.php.dist` to `db.php`
```bash
$ cd bootstrap
$ cp db.php.dist db.php
```

Now you can edit db.php and add your database configuration

## Key files
- `public/index.php`: Application entry point
- `cache/twig/`: Twig cache
- `bootstrap/`: Configuration files
    - `controllers.php`: Registers every controller in the app container
    - `db.php.dist`: Database configuration file model (do not put your database configuration here)
    - `dependencies.php`: Services for Pimple
    - `middleware.php`: Application middleware
    - `settings`: Application configuration
- `src/`
    - `App/`
        - `Controller/`: Application controllers
            - `Controller.php`: Base controller. All controllers should extend this class
        - `Model/`: Eloquent model classes
        - `Resources/`
            - `routes/`: Application routes
                - `app.php`: Main routing file
                - `auth.php`: Routing file for authentication
            - `views/`: Twig templates
