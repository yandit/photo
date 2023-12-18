# Project Name

Brief description of the project and its main objectives.

## Installation

Here are the steps to install and run this project on your local machine.

1. Make sure you have PHP version 8.1.12, Node.js version 8.11.1, and Composer installed on your machine.

2. Clone this repository:

    ```bash
    git clone git@github.com:yandit/photo.git
    ```

3. Navigate to the project directory:

    ```bash
    cd photo
    ```

4. Copy the `.env.example` file to `.env` and configure the `.env` file according to your local environment settings.

5. Install dependencies using Composer:

    ```bash
    composer install
    ```

6. Generate the application key:

    ```bash
    php artisan key:generate
    ```

7. Run migrations and seed the database if needed:

    ```bash
    php artisan migrate
    
    php artisan module:migrate

    php artisan module:seed
    ```

7. storage link:

    ```bash
    php artisan storate:link

    ```

9. Run the development server:

    ```bash
    php artisan serve
    ```

The project can now be accessed at [http://localhost:8000](http://localhost:8000).
