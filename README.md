# Slim base - A Slim 3 skeleton

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/297ce2e4-166d-45d5-8d11-ae0651a8c7ac/mini.png)](https://insight.sensiolabs.com/projects/297ce2e4-166d-45d5-8d11-ae0651a8c7ac) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/awurth/slim-base/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/awurth/slim-base/?branch=master)

This is an app skeleton for the Slim PHP Micro-Framework to get started quickly

## Features
- [Eloquent ORM](https://github.com/illuminate/database)
- Flash messages ([Slim Flash](https://github.com/slimphp/Slim-Flash))
- CSRF protection ([Slim Csrf](https://github.com/slimphp/Slim-Csrf)) with fields rendering with a twig function
- Authentication ([Sentinel](https://github.com/cartalyst/sentinel))
- Validation ([Respect](https://github.com/Respect/Validation) + [Slim Validation](https://github.com/awurth/slim-validation))
- Twig templating engine [Slim Twig View](https://github.com/slimphp/Twig-View) with cache and debug
- CSS Framework [Semantic UI](https://github.com/Semantic-Org/Semantic-UI)
- A **Gulpfile** with a watcher for *SASS* and *JS* files, and minification
- Helpers for assets management, redirections, ...
- An Admin section
- Logs ([Monolog](https://github.com/Seldaek/monolog))
- Dotenv configuration
- Console commands for updating the database schema or creating users
- Functionnal tests base ([PHPUnit](https://github.com/sebastianbergmann/phpunit))

For more information, check out the project's [website](http://awurth.fr/doc/boilerplate/slim) or the [wiki](https://github.com/awurth/slim-base/wiki).

## Installation
### Create the project using Composer
``` bash
$ composer create-project awurth/slim-base [project-name]
```

### Setup environment variables

Copy `.env.dist` to a `.env` file and change the values to your needs. This file is ignored by Git so all developers working on the project can have their own configuration.

### Download client-side libraries
``` bash
$ npm install
```
This will install Gulp dependencies and Semantic UI in `public/assets/lib/semantic/`.

### Gulp
This skeleton uses Gulp to manage assets. The CSS and Javascript files are located in `assets/`, so you have to use Gulp after creating your project to generate the minified files in `public/`, which will be ignored by Git.

#### Install Gulp
You can install Gulp globally on your system with the following command if you haven't done it yet
``` bash
$ npm install -g gulp-cli
```

#### Generate assets
If you just want to generate the default CSS and JS that comes with this skeleton, run the following command
``` bash
$ gulp build
```

If you want to run a watcher and begin coding, just run
``` bash
$ gulp
```

### Setup cache files permissions
The skeleton uses a cache system for Twig templates and the Monolog library for logging, so you have to make sure that PHP has write permissions on the `var/cache/` and `var/log/` directories.

### Update your database schema
First, create a database with the name you set in the `.env` file. Then you can create the tables by running this command:
``` bash
$ php bin/console db
```
