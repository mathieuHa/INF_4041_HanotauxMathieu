Advanced Web Developpement
========================

The project is done for the course Inf 4041 of the 4th Year at ESIEA.

Le Bon Deal
----------------

Le Bon Deal is a website that help people sell
 product they don't want anymore.
 It's a secure website that manage users and products.
 
 Each User can create an account *sign-in* and *login*.
 A user may also reset his password. He will receive more informations by email. 

Non Autenticated user can :
* Consult the list of every item in sale on the website
* See the detail of an item in sale
 
Once logged in the website a user can :
* Add a new product to sell
* Buy a product from another user
* Consult the list and detail of item he has already sold, or is selling
* Consult the list and detail of item he has bought
* Recharge his account with more token (money on the website)


Install the WebSite
--------------

**Requirement :**

The Project use the Symfony Framework in the version 3.3.14 

PHP >= 5.59  
Composer installed globally or download it : [composer.phar](https://getcomposer.org/download/)

**Installation**

*Installation of symfony*
```
php composer.phar install --optimize-autoloader
```
*Creating database*
```
php bin/console doctrine:database:create
```
*Setting up database schema*
```
php bin/console doctrine:schema:create
```
*Clearing the Symfony cache*
```
php bin/console cache:clear --env=prod --no-debug --no-warmup
```
*Warming up the Symfony cache*
```
php bin/console cache:warmup --env=prod
```


