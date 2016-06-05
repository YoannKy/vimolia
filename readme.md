# Installation

### Version
1.0.0


### Prérequis
Installez composer

https://getcomposer.org/doc/00-intro.md

### Installation
Clonez le projet ou téléchargez le au format zip

Lancez la commande composer install pour installer les dépendances du rojet
```sh
$ composer install
```

Puis, créer une base de données de votre choix

Créez un fichier d'environnement ".env" à la racine du projet

et rentrez les informations suivantes:
````
APP_ENV=local
APP_DEBUG=true

DB_HOST=127.0.0.1
DB_DATABASE=nom de votre base de données
DB_USERNAME=votre nom d'utilisateur pour se connecter à la base de données
DB_PASSWORD=votre mot de passe pour se connecter à la base de données

CACHE_DRIVER=memcached
SESSION_DRIVER=memcached
QUEUE_DRIVER=database

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
````

Lancez la commande suivante afin de générer une clé utilisable par l'application

```sh
$ php artisan key:generate
```


Enfin, lancez la commande (depuis la racine du projet) suivante afin de créer les tables et les peupler avec des informations 
```sh
$ php artisan migrate && php artisan db:seed
```
Pour lancer le serveur:
```sh
$ php artisan serve
```




