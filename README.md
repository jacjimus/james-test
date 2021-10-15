
# Laravel+Vue Test for 


## About the application

A very simple Laravel 8 + Vue 2 + AdminLTE 3 based TEST.


## Tech Specification

Create a basic Laravel Application that enables an Administrator to login and manage Companies or Employees. Please don't spend more than 2 hours on the test and submit what you've got at that time.

* Laravel Auth: ability to log in as an admin user
* Use database seeds to create first user with email admin@admin.com and password “password”.
* CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
* Companies DB table consists of these fields: Name (required), email, logo (minimum 100×100), website
* Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone number
* Use database migrations to create those schemas above, and seeders to populate them with 21 records
* Store companies logos in storage/app/public folder and make them accessible from public
* Use Laravel’s validation function, using Request classes
* Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page
* Implement Admin LTE admin theme for the back office: https://github.com/ColorlibHQ/AdminLTE/archive/refs/tags/v3.1.0.zip

Once complete please zip up and email back with any instructions required to get it working.

## Features

- Modal based Create+Edit, List with Pagination, Delete with Sweetalert
- Login, Register, Forget+Reset Password as default auth
- Profile, Update Profile, Change Password, Avatar
- Companies Management
- Employees Management


## Installation

- download the application or from git clone with `git clone https://github.com/jacjimus/james-test.git`
- `cd james-test`
- `composer install`
- `cp .env.example .env`
- `create a mysql database`
- Update `.env` and set your database credentials
- `php artisan key:generate`
- `php artisan migrate --seed`
- `php artisan passport:install`
- `npm install`
- `npm run watch`
- `php artisan serve`
