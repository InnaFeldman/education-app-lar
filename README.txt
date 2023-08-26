Setting Up the Laravel Project
Follow these steps to set up and run the Laravel project:

1. Create the Database
Start by creating a database named 'laravel' in your preferred database management system.

2. Install Dependencies
Run the following command to install the required dependencies using Composer:

bash
Copy code
composer install
3. Run Migrations
Execute the migration command to set up the database tables:

bash
Copy code
php artisan migrate
4. Install Passport
Secure your API endpoints by installing Laravel Passport:

bash
Copy code
php artisan passport:install
5. Start the Development Server
Launch the development server to begin testing your application:

bash
Copy code
php artisan serve