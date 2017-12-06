Le Bon Deal
========================

Le Bon Deal is a website that help people sell
 product they don't want anymore.
 It's a secure website that manage users and products. 

Advanced Web Developpement
--------------

The project is done for the course Inf 4041 of the 4th Year at ESIEA.

Install the WebSite
--------------

**Requirement :**

The Project use the Symfony Framework in the version 3.3.14 
PHP >= 5.59  
Composer installed globally or download composer.phar[https://getcomposer.org/download/]

**Installation**

```
php composer.phar install --optimize-autoloader
```
```
php bin/console doctrine:database:create
```
```
php bin/console doctrine:schema:create
```
```
php bin/console cache:clear --env=prod --no-debug --no-warmup
```
```
php bin/console cache:warmup --env=prod
```