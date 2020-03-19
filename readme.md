

## Install Laravel jwt-auth



- [JSON Web Token Authentication for Laravel & Lumen](https://jwt-auth.readthedocs.io/en/docs/).


## Steup

copy .env.example and save as .env
and set DB_DATABASE=leave-ms

Running php artisan key:generate in a Laravel project to generate Key

Run composer install

Now migrate the tables into database

Run the following command

php artisan migrate:fresh --seed

Or
php artisan migrate

php artisan db:seed

This will create 9 users into database and 1 admin user

The default password for the users is 123456

And for admin credentials are

email = admin@admin.com
password = admin

Install via composer

Run the following command to pull in the latest version:

composer require tymon/jwt-auth "1.0.*"

Publish the config

Run the following command to publish the package config file:


php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

A new config file gets generated in config/jwt.php. Next step is to generate a secret key. We’ll use this key to sign all of our tokens.

php artisan jwt:secret

This command will add a JWT_SECRET value to our .env file. In order to use this jwt-auth package, our User model (or whatever model we’re using to authenticate) must implement the JWTSubject interface. That interface has two methods as we can see here:

To test Run php astisan serve

here is the ui version of the system

https://github.com/knaazimkhan/leave-management-system.git



