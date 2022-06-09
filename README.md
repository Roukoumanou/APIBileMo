# Comment utiliser cette application

1- **Tout dabord, vous aurez besoin de:**

php 8.0 >= 

de composer

et d'un client (postman par exemple)


2- **Clonez ce dépot sur votre machine et rendez-vous à la racine de celui-ci**

3- **Installation**

*Installer avec Make*

Rien de plus simple. A l'interieur de votre dossier donc, tapez la commande suivante

***make install***

Et voilà 

*Installation pas a pas*

Toujours à la racine de votre projet, tapez dans l'ordre les commands suivantes dans votre terminal

***composer install*** //Pour installer les dépendances 

***php bin/console d:d:c*** //Pour créer la base de donnée 

***php bin/console d:s:u -f*** //Pour mètre les tables a jours

***php bin/console d:f:l***  //Tapez entrée pour continuer

***php -S localhost:8000 -t public*** //Pour démarer le serveur interne de php sur le port 8000

Et voilà

*Rdv sur le fichier doc.json pour lire la documentaion de l'API* 

4- **Si vous avez besoin de vous connecter avec l'utilisateur de base dans l'environnement de dévelopement, utilisez les identifiants suivants**

email: bouygue@bilmo.com

mot de passe: password

Enjoy
