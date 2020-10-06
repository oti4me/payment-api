# payment-api
A simple product payment API with recurring payment capability

## Introduction
**`Payment API`** is a simple Application that allows users to add and buy products online; 
* User  Signup
* User Signin
* Add product
* Get products
* Add a product to cart
* Get cart
* Validate payment

## Installation and Setup
*  Install PHP 7.4
*  Install MySQL
*  Navigate to a directory of choice on `terminal`.
*  Clone this repository to that directory.

    > git clone https://github.com/oti4me/payment-api.git .

* Install the application's dependencies using `composer install`

  #### Note
  * In order to begin using, you need to have [PHP](https://php.net) and **composer** installed on your system.
  * For a database, you need to install __MySQL__ locally or setup with an online client.
  * Setup Database according to setting in src/Config/config.php and the env.example file.
  * Migrate to database phinx `vendor/bin/phinx migrate`
  * Create .env file using the config.php, and the .env.example
  * In other to interact effectively with endpoints, install and use [Postman](https://www.getpostman.com/)

* Run the app
  *  `php -S localhost:3001` or any port of your choice.
  *  Running the command above will run the app at `localhost://3001`.

## Dependencies
* See composer.json for reference

## Tests

## Technologies
 * [PHP 7.4](http://php.net/): This is the newest version of PHP  support for all php features.
 * [Composer](https://getcomposer.org/): A package manager for PHP
 * [MySLQ](https://www.mysql.com/): A relational database system
 
# Language
- PHP

## Api Documentation
*[Click here to see the api documentation](https://documenter.getpostman.com/view/1987371/TVRhbURg)

## Limitations
+ Users, Posts, and Cart items cannot be deleted

## Contributions
 Contributions are always welcome. If you are interested in enhancing the features in the project, follow these steps below:
 + Fork the project to your repository then clone it to your local machine.
 + Create a new branch and make features that will enhance it.
 + If you wish to update an existing feature submit a pull request.
 + If you find bugs in the application, create a `New Issue` and let me know about it.
 + If you need clarification on what is not clear, contact me via mail [h.otighe@gmail.com](mailto:h.otighe@gmail.com)

## Author
    Henry Otighe

## License & Copyright
MIT © [Henry Otighe](https://github.com/oti4me)

Licensed under the [MIT License]().
