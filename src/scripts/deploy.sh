#!/usr/bin/env bash

# Make sure the user runs this as root
if [ "$(id -u)" -ne 0 ]
then
    echo "You must run this script as root"
    exit 0
fi

confirmTrue() {
    pass=1
    if [ "$1" != 'n' ]
    then
        echo -n "$2 "
        read -r testt

        if [ "$testt" != 'n' ]
        then
            pass=0
        fi
    else
        pass=0
    fi
    return $pass
}

rebuild=1
if [ "$1" != 'rebuild' ]
then
    rebuild=0
fi

echo ""
echo -n "Use interactive deploy (RECOMMENDED)? (Y/n)"
read -r inter
if [ "$inter" != 'n' ]
then
    inter="Y"
fi

echo "Installing required modules..."
composer install
composer dump-autoload

php artisan cache:clear
php artisan route:clear

# cp .env.example .env

echo ""
if confirmTrue $inter "Execute database migrations now? (Y/n) "
then
    echo ""
    if [ "$rebuild" != '0' ]
    then
        php artisan migrate:refresh --seed
    else
        php artisan migrate --seed
    fi
fi

echo ""
echo "Starting the import NFe job"
php artisan dispatch:job ImportNfe

echo ""
if confirmTrue $inter "(Re)generate application key? (Y/n) "
then
    php artisan key:generate
    php artisan key:generate --env=testing
fi

chmod 777 storage/ -R
chmod 777 bootstrap/cache/ -R
