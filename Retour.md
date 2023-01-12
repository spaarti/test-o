Retour sur l'exercice après 1h30 passé :

- J'ai commencé par nettoyer les fichiers et installé mes outils de développement

    Php Stan, notamment, permet d'avoir un code avec moins de bugs grâce aux points d'alerte relevé

- J'ai découpé le fichier templateManager et ajouter un système de gestion de tags.

    Cette approche permet une plus grande évolutivité et compréhension du code.

    Ainsi, on pourra utiliser en parent ou dupliqué la classe TemplateBasicTag qui permet de remplir un tableau associatif [TAG => value]

    On pourra facilement ajouter de nouvelles fonctionnalités et de nouveaux tags

    Actuellement, c'est un tableau associatif par manque de temps, je n'ai pas créé de collection dédiée, mais c'est recommandé.

- Le singletonTray n'est pas optimal, il faudrait également le remplacer par un système d'injection de dépendance.

- Les repositories utilisé dans la classe Manager (ou ici son hydrator) n'est pas optimal, on devrait envoyer ses données directement depuis le contrôleur, le problème actuel est que si on a 1000 emails à envoyé, on risque de faire 1000 requêtes. Sortir au niveau du contrôleur évite les fuites de performances surtout en cas de boucles.

    Dans l'exercice actuel, je n'ai pas fait cette sortie, déjà par manque de temps et ensuite parce que la signature de la méthode ne pouvant pas être changé, il est fort probable que le constructeur ne puisse pas l'être non plus.

- il aurait également fallu créer des tests unitaires dédiés aux nouvelles classes.

- et idéalement découpé encore un peu plus

    Ce qui n'a pas été fait par manque de temps, mais ça permet d'avoir un exemple concret de ce que j'imagine en refactorisant en suivant les contraintes de l'énoncé.
    
 - j'ai ajouté des commentaires partout avec les typages ça permet aux IDEs qui le supportent de faire une bonne autocomplétion
 
 - j'ai bien entendu vérifié que les tests unitaires fonctionnaient et ajoutés quelques modifications pour tester mes ajouts