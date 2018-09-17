# Charities Directory
Web based charities directory built using Symfony4.

## Prerequisites

PHP 7.1.16

Symfony 4.1.4

Composer version 1.8-dev

## To download and run:
In a terminal window, type:

    https://github.com/alinemokfa/charities_directory.git (for HTTPS) or git@github.com:alinemokfa/charities_directory.git (for SSH)

    cd charities_directory

    composer install

    php bin/console doctrine:fixtures:load

    php bin/console server:run

Now please visit `http://localhost:8000` in your browser.

To sign in as an admin: 
username: admin
password: 0000

To sign in as a user:
username: user
password: 0000


## To run tests:
In a terminal window, type:

   php bin/phpunit
