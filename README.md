<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Poke APP Project Setup

This guide will help you get started with a Laravel project using Laravel Sail, Docker's simple command-line interface for managing Laravel applications.

## Prerequisites

- Docker Desktop installed on your machine.
- Composer installed globally.

1. Clone the project repository:
   ```bash
   git clone git@github.com:jhonnstark/poke-app.git
   ```

2. Navigate into the project directory:<pre>cd <project-directory> </pre>
3. Install PHP dependencies:  <pre>composer install </pre>
4. Copy the .env.example file to .env:  <pre>cp .env.example .env </pre>
5. Generate an application key:  <pre>php artisan key:generate </pre>
6. Start Laravel Sail:  <pre>./vendor/bin/sail up -d </pre>
7. Run the database migrations (Ensure the Docker containers are up and running):  <pre>./vendor/bin/sail artisan migrate </pre>
8. (Optional) Seed the database:<pre>./vendor/bin/sail artisan db:seed </pre>

## Usage
To access your application, open http://localhost in your web browser.
To stop the Docker containers, run:<pre>./vendor/bin/sail down </pre>
## Additional Commands
To run any Artisan commands:<pre>./vendor/bin/sail artisan <command> </pre>
To access the application shell:<pre>./vendor/bin/sail shell </pre>
For more information on Laravel Sail, visit the official documentation.
## Troubleshooting
If you encounter permission issues, make sure Docker has the necessary permissions to access your project directory.
For any other issues, refer to the Laravel Sail documentation or check the Laravel community forums and Discord server.
