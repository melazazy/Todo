# TODO List Application

This is a TODO list application built with Laravel and Livewire. Follow the instructions below to set up and run the application.

## Table of Contents

- [Prerequisites](#prerequisites)
- [Setup Instructions](#setup-instructions)
- [Running the Application](#running-the-application)
- [Accessing the Application](#accessing-the-application)
- [Usage](#usage)
- [Summary](#summary)

## Prerequisites

Before you begin, ensure you have the following installed:

- **PHP**: Version 8.0 or higher.
- **Composer**: Dependency manager for PHP.
- **MySQL**: Database server (or any other compatible database).
- **Node.js**: For managing frontend dependencies.
- **Laravel**: If you haven't already installed Laravel globally, you can do so via Composer.

## Setup Instructions

1. **Clone the Repository**

   Open your terminal and navigate to the directory where you want to clone the project. Run the following command:

   ```bash
   git clone https://github.com/yourusername/TODO.git

2. **Navigate to the Project Directory**
   
   Change into the project directory:
   
   ```bash
    cd TODO

3. **Install PHP Dependencies**

    Use Composer to install the required PHP packages:

   ```bash
    composer install

4. **Set Up Environment File**

    Open the `.env` file in a text editor and configure your database settings:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database_name
    DB_USERNAME=your_database_user
    DB_PASSWORD=your_database_password

5. **Generate Application Key**

    Run the following command to generate a new application key:

   ```bash
    php artisan key:generate

6. **Run Database Migrations**

    Run the database migrations to create the necessary tables:

   ```bash
    php artisan migrate

7. **Seed the Database**

    Run the database seeds to populate the database with initial data:

   ```bash
    php artisan db:seed

8. **Start the Application**

    Run the following command to start the Laravel development server:

   ```bash
    php artisan serve

9. **Access the Application**

    Open your web browser and navigate to `http://localhost:8000` to access the TODO list application. 

