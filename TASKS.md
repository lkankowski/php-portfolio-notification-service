# E-Shop REST Api

## Setup
```shell
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## Run tests
One time:
```shell
php bin/console doctrine:database:create --env test
php bin/console doctrine:migrations:migrate --no-interaction --env test
Run all tests
```
```shell
vendor/bin/codecept run
```

## Requirements
Create a simple application allowing adding products to the cart. The application should
consist of two HTTP APIs (in a RESTful manner if possible):

## Guidelines:
* There is no need for frontend UI (unless you really want to show your frontend skills as well ;))
  just expose every action through REST APIs.
* Code should be PHP-based
* Tests are very welcome
* Assume high-load application
* Impress us, you can over-engineer it - we want to see your programming skills

## 1. Products catalog API:
   Our catalog contains the following products:

| ID  | Title         | Price    |
|-----|---------------|----------|
| 1   | Fallout       | 1.99 USD |
| 2   | Don’t Starve  | 2.99 USD |
| 3   | Baldur’s Gate | 3.99 USD |
| 4   | Icewind Dale  | 4.99 USD |
| 5   | Bloodborne    | 5.99 USD |

The API should expose methods to:
* Add a new product
  * Product name should be unique
* Remove a product
* Update product title and/or price
* List all of the products
  * There should be at least 5 products in the catalog (the ones in the table
       above)
  * This list should be paginated, max 3 products per page

## 2. Cart API

API that allow adding products to the carts. User can add multiple items of the same product\
(max 10 units of the same product).

This API should expose methods to:
* Create a cart
* Add a product to the cart
* Remove product from the cart
* List all the products in the cart
  * User should not be able to add more than 3 products to the cart
  * You should return a total price of all the products in the cart

## TODO
- authentication and permissions???
- 
