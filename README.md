# Laravel and Svelte

## Prerequisites

* PHP 7.4 or higher
* Composer
* Node.js
* npm

## Installation

1. Clone the Git repository

```
$ git clone <repository URL>
```

2. Install Laravel dependencies

```
$ cd api
$ composer install
```

3. Install Vue.js dependencies

```
$ npm install
```

4. Copy the .env.example file to create a .env file

```
$ cp .env.example .env
```

5. Generate an application key

```
$ php artisan key:generate
```

## Start the development server

```
$ php artisan serve
```

Access the api in your browser by visiting http://localhost:8000.

## Compiling Assets

To compile assets for the development environment, run the following command:

```
$ npm run dev
```

Access the application in your browser by visiting http://localhost:5173.

To compile assets for the production environment, run the following command:

```
$ npm run prod
```
