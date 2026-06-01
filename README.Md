# LaGuildeDesSeigneursFull

## Idée du projet
Créer un projet Symfony pour gérer des personnages de la guilde des seigneurs. Le projet inclut l'entité `Character`, un CRUD, des fixtures et une interface avec Twig.

## Création du projet
Aller dans le répertoire parent qui contiendra le répertoire du projet.

Avec Symfony CLI :
```bash
symfony new LaGuildeDesSeigneursFull --version="7.4.*" --webapp
# ou
symfony new LaGuildeDesSeigneursFull --webapp
```

Sans Symfony CLI :
```bash
composer create-project symfony/skeleton:"7.4.*" LaGuildeDesSeigneursFull
cd LaGuildeDesSeigneursFull
composer require webapp
```

## Configuration du dépôt Git
```bash
cd LaGuildeDesSeigneursFull
git add .
git commit -m "Mise en place projet"
```

Ajouter le dépôt distant :
```bash
git remote add origin git@github.com:VOTRE_DEPOT_GITHUB.git
git branch -m master main
git push -u origin main
```

Créer une branche de développement :
```bash
git checkout -b dev
```

## Versions et releases
```bash
git tag -a v0.1 -m "Version 0.1"
git push origin --all
git push origin --tags
```

## Base de données
Créer la base de données `guilde_seigneurs_full` et configurer `.env.local` :
```dotenv
DATABASE_URL="mysql://guilde_write_f:Y7*Z3PZ9cBNz@127.0.0.1:3306/guilde_seigneurs_full"
```

## Entité Character
Créer l'entité `Character` avec les propriétés suivantes :
- identifier : string(40) not null
- name : string(20) not null
- slug : string(20) not null
- kind : string(20) not null
- surname : string(50) not null
- caste : string(20) null
- knowledge : string(20) null
- intelligence : smallint null
- strength : smallint null
- image : string(50) null
- creation : datetime not null
- modification : datetime not null

Modifier la classe pour ajouter la table :
```php
#[ORM\Entity(repositoryClass: CharacterRepository::class)]
#[ORM\Table(name: '`character`')]
class Character
```

## Migration et données
```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

Charger les fixtures :
```bash
composer require --dev orm-fixtures
php bin/console doctrine:fixtures:load
```

## CRUD
Générer le CRUD pour l'entité `Character` :
```bash
php bin/console make:crud
```

## Serveur
Démarrer le serveur Symfony :
```bash
symfony serve
# ou
symfony server:start
```

Accéder à l'application :
http://127.0.0.1:8000/character/

## Objectif frontend
Utiliser Twig pour afficher les personnages, franciser les titres, adapter l'affichage du tableau et rendre l'interface plus propre.
