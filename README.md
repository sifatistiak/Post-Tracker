# Laravel Project - Post Impression / Click Tracker

## Pre-Requisite
* PHP 8.1
* MySQL 
* Redis

## Installation

    1. Clone the project
    2. Change Directory
    3. Install dependencies
    4. Create a .env file 
        4.1 Copy the .env.example and replace your credentials accordingly
    5. Generate an application key
    6. Migrate the database
    7. Start the server

```bash
  git clone https://github.com/sifatistiak/Post-Tracker.git

  cd Post-Tracker
  
  composer install

  cp .env.example .env

  php artisan key:generate

  php artisan migrate

  php artisan serve


```

This will start the server on http://localhost:8000 by default. You can access the website by opening a web browser and navigating to that URL.



#### Note: The homepage / welcome page itself contains the tracker. ####
