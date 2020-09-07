# Banking App Assignment

# Stack I used Overall:
* Laravel 7
* Vuejs(Nuxt)
* MariaDB
* Nginx
* Docker/Docker Compose

API:
   * Laravel
   * MariaDB
Web:
   * NuxtJS
   
Packages used for the Api that was essential
    * laravel/passport
    * BenSampo/laravel-enum
    * larachimp/mango-repo

Project runtime
 The api and the web part is running on docker containers.  I have a used a small part of laradock for this project.

Installation
    To run the project you'll need docker and docker-compose
Git Clone the project first by running:
    `git clone https://github.com/ravishdussaruth/test-mailerlite.git`
Copy the docker env:
    `cp env-example .env`
Run the containers
    `docker-compose up -d`

Prepare the db:
Goto localhost:8080 to use phpmyadmin web interface.
* Create a new db from the panel name `banking_app`

Install The Api.
SSH into the workspace container.
    `docker-compose exec --user=laradock workspace bash`
Go to api folder.
* `cd api`
* Then copy the .env first
        `cp .env.example .env`
* Run `composer install`
* Run `php artisan key:generate`
* Migrate the database by running:
    * `php artisan migrate`
* Seed the database with dummy data:
    * `php artisan seed:db --class=DatabaseSeeder`
    
To run all test.
*   `pu`

---
The web part will automatically be built when the containers will run.

* Or inside the workspace container
    *   Got to the web folder
    *   Run `yarn dev`
---
For every account create a client secret and id will be created.
Steps To create an account:
1. SSH into the workspace container
2. When inside the container, go to api directory.
    `cd api`
3. Run `php artisan make:account`
4. Here you will need to provide the details needed.
5. When completed, you will need to use your bank id, client id and secret for authentication.

In case you want to know an existing account, credentials.
Steps:
1. SSH into the workspace container
2. When inside the container, go to api directory.
    `cd api`
3. Run `php artisan search:account`
4. Enter the bank account id.
5. From that you will receive the client id and secret to authenticate the user.

## Shortcuts
* Go to main directory where `containers` file is found.
* Run `./containers start` to start all docker containers
* Run `./containers stop` to stop all docker containers.
* Run `./containers workspace` to ssh into workspace container

Endpoints:
Api: localhost
Web: localhost:3000