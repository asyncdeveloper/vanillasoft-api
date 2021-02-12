# Laravel API for Emails
> A simple API to send multiple emails asynchronously

## Description
This project was built with Laravel and MySQL.

##### Integration testing :
- PHPUnit (https://phpunit.de)
- Faker (https://github.com/fzaninotto/Faker)

## Running the API
To run the API, you must have:
- **PHP** (https://www.php.net/downloads)
- **MySQL** (https://dev.mysql.com/downloads/installer)

Create an `.env` file using the command. You can use this config or change it for your purposes.

```console
$ cp .env.example .env
```

### Environment
Configure environment variables in `.env` for dev environment based on your MYSQL database configuration

```  
DB_CONNECTION=<YOUR_MYSQL_TYPE>
DB_HOST=<YOUR_MYSQL_HOST>
DB_PORT=<YOUR_MYSQL_PORT>
DB_DATABASE=<YOUR_DB_NAME>
DB_USERNAME=<YOUR_DB_USERNAME>
DB_PASSWORD=<YOUR_DB_PASSWORD>
```

# API documentation
API End points and documentation can be found at:
[Postman Documentation](https://documenter.getpostman.com/view/5928045/TWDRsfX6)

List of all API endpoints:

>POST /api/send

>GET /api/list

### Making Requests
Enable Bearer Token on API calls. use the value in `API_KEY` in for token.
Kindly check API documentation for sample

### Installation
Install the dependencies and start the server

```console
$ composer install
$ php artisan key:generate
$ php artisan migrate
$ php artisan serve
```

You should be able to visit your app at http://localhost:8000

## Testing
To run integration tests:
```console
$ composer test
```
