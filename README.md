# Application Appartements

## Description
Application web pour permettre d'avoir une aide au remplissage de la déclaration d'impôts, lorsque l'utilisateur a un parc d'appartements à gérer.

## Documentation technique
MVC utilisé : Symfony 6.3 
BDD : Sql, via PHPMyAdmin
Bootstrap : 5.3

Mise à jour des scripts et css : 
utilisation du bundle Webpack Encore. 
Les nouveaux fichiers de scripts et css doivent être ajoutés dans le dossier assets, afin qu'ils puissent ensuite être compilés dans le dossier public/build
Pour une mise à jour en continu, faire la commande :
```npm run watch```

Pour une mise à jour ponctuelle, faire la commande : 
```npm run dev```