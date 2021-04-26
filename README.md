# WHES Platform Web Application

This web application is based on Yii 2 Advanced Project Template - a skeleton [Yii 2](http://www.yiiframework.com/) application best for
developing complex Web applications with multiple tiers.


DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```


## Installation


### 1. Clone repository

git clone git@github.com:interactis/whes-platform.git

### 2. Install dependencies with composer

Go to the application directory and install composer:
```
curl -sS https://getcomposer.org/installer | php
```

Install the dependencies:
```
php /path/to/web-application/composer.phar install
```

The install command reads the composer.json file from the current directory, resolves the dependencies, and installs them into vendor.
More information about composer: https://getcomposer.org/doc/00-intro.md

### 3. Select environment

Execute the `init` command and select `dev` or `prod` as environment:
```
php /path/to/web-application/init
```

### 4. Setup database

1. Create a new Postgres database.

2. Execute the `yii migrate` command to apply the yii database migrations:
```
php /path/to/web-application/yii migrate
```

3. Use `/start.sql` as a starting point. Or ask info@interactis.ch for an export of the productive database and import it.


### 5. Configurations

Configure the application in the following config files:
* common/config/main-local.php
* common/config/params-local.php
* frontend/config/main-local.php
* frontend/config/params-local.php
* backend/config/main-local.php
* backend/config/params-local.php
* console/config/main-local.php
* console/config/params-local.php


### 6. Set document roots of your web server

* for backend /path/to/web-application/backend/web/ and using the URL https://admin.YOUR-DOMAIN.ch
* for api /path/to/web-application/api/web/ and using the URL https://api.YOUR-DOMAIN.ch


### 8. Enable .htaccess

Yii UrlManager uses .htaccess files to show clean and pretty URLs.


## Updates

Please follow these steps to update your existing web application to the latest version:


### 1. Get the latest source code

```
git pull
```

### 2. Update the dependencies

```
php /path/to/web-application/composer.phar update
```

### 3. Delete cached asset files

Sometimes it is required to delete all files and directories in these directories:
* /path/to/web-application/backend/assets
* /path/to/web-application/frontend/assets

