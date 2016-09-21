# Picture Labelling Game 

Version 1.1.1

## About 

1. Get a random picture from the library
2. Tag that picture
3. Do not use tags in taboo list
4. Get points for the matches against your competitor

Application based on Laravel PHP Framework version 5.2.30

## Requirements

* PHP 7.0 and higher

* SSH enabled on server

* Composer
  
* Supports databases
  * MySQL
  * Postgres
  * SQLite
  * SQL Server
  (Tested on MySQL 5.5)
  
## Installation 

### 1. Install dependencies

Run `composer install` command in the root folder of the project.

### 2. Edit the configuration file (incl. database configuration)

`.env.example` and change its name to `.env`

### 3. Make sure `.htaccess` file in `public` directory and server config files are configured correctly

#### Example of my .htaccess

```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On
    # XXX Not present in original
    RewriteBase /labellinggame

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    # XXX Add base back on slash magic, not present in original
    RewriteRule ^(.*)/$ /labellinggame/$1 [L,R=301]
    #RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Handle Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>
```

### 4. Import the database scheme and default pictures

Run `artisan migrate` to create database tables

Run `php artisan db:seed` to add default pictures

## Post-installation procedures

Register a new user. The first user of the system is admin by default. Admin can upload pictures, view and get statistics. 

## Development

 Use
 
```
bower install
gulp copyfiles
gulp
```

commands to build `.js` and `.css`  files  
