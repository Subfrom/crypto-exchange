# Cryptocurrency Exchange System

This project is a cryptocurrency exchange system built with PHP Laravel. It supports the buying and selling of cryptocurrencies (BTC, ETH, XRP, DOGE), recording money transfers and exchanges, and creating user accounts.

## Requirements

- PHP >= 7.4
- Composer
- MySQL
- Laravel 8.x or 9.x
- Postman (for API testing)

## Installation

1. **Clone the repository:**

   ```sh
   git clone https://github.com/your-username/cryptocurrency-exchange.git
   cd cryptocurrency-exchange
   ```
2. **Install Package:**   
   ```sh
   composer install
   ```
3. **Copy ENV:**
    ```sh
    cp .env.example .env
    ```
4. **Config ENV:**
   ```sh
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=crypto_exchange
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```
5. Generate application key
   ```sh
   php artisan key:generate
   ```
7. Run migrations and seed the database
   ```sh
   php artisan migrate --seed
   ```
8. Running Project
   ```sh
   php artisan serve
   ```
   POSTMAN FILE NAME : Crypto Exchange API.postman_collection.json
