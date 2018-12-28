# symfonyDemo


## Requirements
* Apache
* Visual Studio, Sublime Text ou Atom
* MySql
* phpMyAdmin
* Php > 7.1.3
* Composer > 1.7.2
* Git

## Installation des outils

Selon votre système installez Mamp ou Wamp (version 64bits) et pensez à sélectionner une version de PHP > à 7.1.3

Installez "Composer" soit directement sur votre machine Windows en installant l’exécutable soit en utilisant le fichier composer.phar à la racine de votre projet. 
Voir le site [Composer](https://getcomposer.org/download/)

Installez la prise en charge de Git en ligne de commande [GIT](https://git-scm.com/downloads)

Vous pouvez tester vos version de PHP et Composer :
`$ composer -V`
`$ php -v`
Si ces deux lignes de commandes vous renvoient des informations tout est OK !

## Installation

* En ligne de commande placez vous dans le répertoire web de Wamp ou Mamp (www ou htdocs...). (ex `$ cd c:/wamp/www/`)
* Cloner le dépôt distant avec `$ git clone https://github.com/nienfba/symfonyDemo.git`
* Déplacer vous dans le répertoire `symfonyDemo` qui a été créé avec le clonage `$ cd symfonyDemo/`
* Maintenant il s'agit d'installer Symfony et ses dépendances, la base de données et d'y injecter le contenu pour celà :
 * `$ composer install` ou `$php composer.phar install`. Cette commande peut prendre plusieurs minutes :(
 * une fois le framework et ses dépendances mises à jour, modifier le fichier .env à la racine du répertoire `symfonyDemo`. Trouvez le ligne `$ DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name` 
Remplacez db_user et db_password et db_name par vos valeurs locales. Pour une installation standard de Wamp ou Mamp (ici le mot de passe est vide et la base s'appelle hackathon !!) : 
`$ DATABASE_URL=mysql://root:@127.0.0.1:3306/hackthon`
 * Nous allons maintenant créer la base de données, c'est automatique avec symfony !!:
`$ php bin/console database:create`
 * Puis créer les tables de la bases :
 `$ php bin/console make:migration`
 `$ php bin/console doctrine:migrations:migrate`
Il faut répondre "y" à la question "WARNING ! ...."
 * Puis nous allons insérer les données dans la base : 
 `$ php bin/console doctrine:fixtures:load`
Répondre "y" à la question "WARNING ! ...."
* Nous allons lancer un serveur Web avec PHP et les outils Symfony pour un fonctionnement optimal. On ne va pas passer par Apache donc, mais par un serveur Web spécifique.
`$ php bin/console serveur:run`
* Vous pouvez maintenant cliquer sur l'url proposée (normalement : http://127.0.0.1:8000)
* OUF ! All is done !! Go to Work ;)
* Vous pouvez continuer la création !!
