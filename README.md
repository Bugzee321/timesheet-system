# Project Setup and Run Guide

This project is built using Laravel and depends on Docker, Docker Compose, and Passport for API authentication. Follow the steps below to set up and run the project.

## Prerequisites

- Docker
- Docker Compose
- PHP
- Composer

## Setup Instructions

1. **Clone the repository:**
   ```sh
   git clone <repository-url>
   cd <repository-directory>
   ```

2. **Copy the example environment file and configure it:**
   ```sh
   cp .env.example .env
   ```

3. **Install PHP dependencies:**
   ```sh
   composer install
   ```

4. **Generate application key:**
   ```sh
   php artisan key:generate
   ```

5. **Run Docker containers:**
   ```sh
   docker-compose up -d
   ```

6. **Run database migrations:**
   ```sh
   php artisan migrate
   ```

7. **Generate Passport keys:**
   ```sh
   php artisan passport:keys
   ```

8. **Create a personal access client for Passport:**
   ```sh
   php artisan passport:client --personal
   ```

9. **Generate Swagger documentation:**
   ```sh
   php artisan l5-swagger:generate
   ```

10. **Run database migrations for testing environment:**
    ```sh
    php artisan migrate --env=testing
    ```

11. **Seed the database for testing environment:**
    ```sh
    php artisan db:seed --env=testing
    ```

## Running Tests

To run the tests, use the following commands:

1. **Run all tests:**
   ```sh
   php artisan test
   ```

2. **Run tests for testing environment**
   ```sh
   php artisan test --env=testing
   ```

## API Documentation

The API documentation is available at:

http://localhost/api/documentation

## Authentication

The project uses Passport for API authentication.