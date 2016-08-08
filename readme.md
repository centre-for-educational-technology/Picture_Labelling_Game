# Picture Labelling Game 

## About 

1. Get a random picture from the library
2. Tag that picture
3. Do not use tags in taboo list
4. Get points for the matches against your competitor

Application based on Laravel PHP Framework version 5.2.30

## Requirements

- PHP 7.0 and higher

- SSH enabled on server

- Composer
  
  * Supports databases
    * MySQL
    * Postgres
    * SQLite
    * SQL Server
    (Tested on MySQL 5.5)
  
## Installation 

### 1. Install dependencies

Run `composer install` command in the root folder of the project.

### 2. Import the database scheme

Run `artisan migrate` to create database tables

### 3. Edit the configuration file

`.env.example` 

### 4. Make sure `.htaccess` file in `public` directory and server config files are configured correctly

## Post-installation procedures

Register a new user. The first user of the system is admin by default. Admin should upload pictures to start using the game. 

## Development
 
Use `gulp copyfiles` and `gulp` commands to build `.js` and `.css`  files  