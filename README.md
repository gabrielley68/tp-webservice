# WebService TP
* Use ```$composer install``` to install all dependencies
* Setup your database in the .env file and run ```$ php bin/console doctrine:schema:create```
* Run your local server with : 
``` $php -S 127.0.0.1:8000 -t public ```
 OR
```$ composer req server --dev``` + 
```$ bin/console server:run```
* Make your HTTP request on localhost:8000/api/[your request]
