# projet demo Symfony 2

## site Web partage de musique
Ce projet est un projet de démonstration sur lequel j'ai travaillé dans le but de  mettre en pratique mes connaissances sur le Framework PHP Symfony 2.

## présentation de l'application
L'application utilise la version strandard du framework Symfony et des composants tiers.
Parmi les éléments que j'ai utilisé :
* Formulaires
* Routes
* Captcha
* Doctrine
* Services
* Evénements
* Validation des données
* Tests
* Twig et Assetic
* SwiftMailer

## fonctionnalités
Un utilisateur peut consulter le site sans être inscrit, il dispose alors d'un simple accès aux fichiers disponibles.
Il est possible de s'inscrire sur le site, cela permet de déposer des fichiers. Les fichiers disponibles sur le site concernent un type de musique, ils sont publics ou privés. Pour avoir accès aux fichiers privés d'un utilisateur celui-ci doit vous ajouter dans sa liste d'amis. De même si vous voulez partager vos fichiers privés avec un ou plusieurs utilisateurs, vous devez les ajouter dans votre liste d'amis.
Un captcha est utilisé sur le formulaire de login, la gestion des utilisateurs enregistrés est faites avec l'ORM Doctrine, le mot de passe utilisateur est crypté en base de données.
L'administrateur du site à la possiblité de gérer (ajouter/supprimer/mettre à jour) les nouvelles disponibles sur le site.

### Reste à faire
- Intégration/desgin, ce qui est en place n'est pas travaillé.
- Tri des fichiers par catégories/utilisateurs
- Intégration du lecteur de fichier son en popup (permettre de naviguer sur le site en écoutant un fichier)

