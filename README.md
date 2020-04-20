# JapaLearn
Japalearn is a tool that helps people learn the japanese language. This tool offers a spaced repetition algorithm to make it easier to learn and memorize Japanese vocabulary. It also offers a place where teachers and students can connect to boost the learning process of the students.

## Setting up the workspace
Here are the steps to start working on this project

### Requirements

1. PHP >= 7.2.12 (https://windows.php.net/download#php-5.6)
1. Composer >= 1.10.1 (https://devanswers.co/install-composer-php-windows-10/)
1. Node.js >= 6.14.4 (https://www.npmjs.com/get-npm)
1. MySQL >= 8.0.18
1. A PHP IDE. Personnaly, I like PHPStorm, but you can use wathever you want.

### Installation
1. Start by cloning this repository on your computer
1. Create a new database: `CREATE DATABASE japalearn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`
1. Copy the file .env.example to .env
1. Edit the file and change the fields `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD` to allow the app to connect to the created database
1. Run `npm install` to install the node.js dependencies
1. Run `composer install` to install the PHP dependencies
1. Create the database tables by running `php artisan migrate`
1. Populate the database by running `php artisan db:seed` - This will create the default users, roles, etc...
1. Configure Passport by running `php artisan passport:install` - Passport is a package allowing to authenticate users when they query APIs endpoints.
1. Generate the Passport keys by running `php artisan passport:keys`
1. Create storage symbolic link: `php artisan storage:link`

## How to test localy
1. Run `php artisan serve` to launch the web app
1. The command `php artisan db:seed` created multiple users of different roles.

### Test users
To login go to http://localhost:8000/login

| email                   | Role    | Password     |
|-------------------------|---------|--------------|
| student@japalearn.com   | Student | snTK*st0KG2K |
| teacher@japalearn.com   | Teacher | snTK*st0KG2K |
| admin@japalearn.com     | Admin   | snTK*st0KG2K |


## Project files
Laravel separate the files following the MVC rules (Model - View - Controller).
The models are located in `app/Models`.
The controllers are located in `app/Http/Controllers`. I separeted the controllers in two categories "apis" controllers and the others.
All the view related files are under `resources/`.

The VueJS components are in `resources/js/components`. They are registered in the file `resources/js/app.js`.

The VueJS components are used in "blade" templates. These templates are in the `resources/views` directory. Blade templates have been created by Laravel and allow to easily mix php code with html. You can read more about them here: https://laravel.com/docs/7.x/blade


## Usefull resources
I recommended to quickly go through these documentations:
1. Laravel documentation (version >= 7.0): https://laravel.com/docs/7.x/
1. VueJS documentation https://vuejs.org/v2/guide/
1. How to create **tests** with Laravel: https://laravel.com/docs/7.x/testing
