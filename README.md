# Laravel Project - Post Impression / Click Tracker

## Pre-Requisite
* PHP 8.1
* MySQL (Database need to be set up in advance)
* Redis

## Installation

    1. Clone the project
    2. Change Directory
    3. Install dependencies
    4. Create a .env file 
        4.1 Copy the .env.example and replace your credentials accordingly
    5. Generate an application key
    6. Migrate the database (Database needs to be created before that and must be added in .env)
    7. Start the server (Keep it running on background)
    8. Start the queue

```bash
  git clone https://github.com/sifatistiak/Post-Tracker.git

  cd Post-Tracker
  
  composer install

  cp .env.example .env

  php artisan key:generate

  php artisan migrate

  php artisan serve

  php artisan queue:listen

```

This will start the server on http://localhost:8000 by default. You can access the website by opening a web browser and navigating to that URL.



#### Note: The homepage / welcome page itself contains the tracker. ####


After browsing the page, the tracker collects the data and send it to backend. The data is then collected into Redis (through queue) and to aggregate those data from Redis to MySQL run this command - 


```
php artisan aggregate:campaign
``` 

After running this command data will be transferred to DB and associated data from Redis would be cleared out. 

