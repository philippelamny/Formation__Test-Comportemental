# Qu'est-ce que c'est

Le test comportemental est un ensemble de test qui va décrire le comportement que l'on souhaite pour un cas d'utilisation donné.
Dans le trio des "D", nous retrouvons le BDD "Behavior Driven Developement". Un concept permettant de décrire tout un jeu d'exemple permettant de clarifier le cas d'utilisation.

# Pourquoi ?

Il va décrire l'ensemble des comportements décrits dans les spécifications "métiers" du cas d'utilisation.
De manière unitaire, tous les comportements doivent apparaître lors de l'exécution des tests.
Les noms des tests doivent être compréhensifs par Le métier.
Cela va permettre de créer de la documentation dynamique et vérifier si nous avons le comportement voulu.
Il n'est pas utile d'avoir tous les détails de l'implémentation dans le nom.
L'utilité des tests est d'avoir un garde fou sur les cas indésirables. Mais le plus important est de permettre la refactoriser du code. (Todo : les bienfaits de la refactorisation)
Si les tests se basent sur l'aspect technique de l'implémentation, il sera difficile de maintenir la documentation car la technique reste du bas niveau et lors d'une refactorisation, on devra modifier le test (surtout les noms pour rester en adéquation avec la refacto), alors que le comportement n'est jamais censé changer.

Ex:
Bas niveau: then throw exception name already exist
Haut niveau: inform name already exist

Pensez au prochain collègue qui va passer sur vos tests. Il aura une meilleur compréhension du cas d'utilisation si les noms sont bien plus pertinent et correspondent à un comportement.
Il est important que les noms soient normalisés par l'équipe car comme pour le code, on ne doit pas distinguer le code de chacun (utopique)

# Test unitaire

Il y a différents types de test (Integration, Unitaire, EndToEnd).
Ici nous allons nous concentrer sur les unitaires, c'est à dire sur une class spécifique et notamment sur son comportement.
Ce qui veut dire qu'on ne teste pas une structure (ex: data transfert object "DTO") mais un object (class avec des regles métiers).
Le principe est de couvrir de test sur l'ensemble des comportement de l'objet de manière isolée et simuler les services dépendants.
On testera alors les méthodes publiques et toute la complexcité de cette méthode.

# Concept du FIRST

Les tests unitaires doivent respecter le concept du FIRST :

- Fast
- independant / isolate
  Triple A (Arrange, Act, Assert)
- Repeatable
- Self Validation
- Thorough : couverture de tous les cas et non 100% des données

# Différents concepts à connaitre

- concept de cas d'utilisation
- autowirering (Optionnel)
- cqs (Optionnel)
- injection de dépendance par interface a la construction de l'objet
- test unitaire avec Phpunit et notion Mock

# Différence entre test unitaire et test d'intégration

Concept du port / adpateur
Dans un test unitaire, on test le class object (cas d'utilisation) et on simule les ports (les interfaces des services)
Dans un test d'intégration, on choisit d'intégrer dans nos tests, un adapteur (class implémentation d'un ou pusieur service)

# Test collaborative Vs Test denouement

## Collaborative
Dans le cas pratique, nous allons tester de manière collaborative. 
Ce qui veut dire que l'on va simuler/mocker les différents comportements des services (les adpateurs) 
pour valider le comportement de notre cas d'utilisation.
l'avantage est qu'on peut très vite arriver à un résultat en mockant les méthodes définies dans les ports.
Mais cela aura un réel coût sur le couplage des tests et il faudra probablement changer les tests : 
- si on modifie la signature d'une méthode du port,
- si on change le nom d'une méthode du port
- si le cas d'utilisation utilise une autre méthode
Cela briserait le concept de la refacto grace aux tests écrits déjà écrits.
La refacto ne doit pas changer le comportement, donc ne doit pas changer les tests.


## Dénouement
Denouement (des tests avec le pattern Mémento (https://refactoring.guru/fr/design-patterns/memento))
- Utilisation des class InMemory
- Pas de couplage avec les implémentations dans le handler
- les tests sont plus faciles à lire car la logique est déportée dans les class InMemory au lieu de voir les mock
- les tests sont plus court, command + handle + assert Value Model
- On peut utiliser nos class de InMemory dans une version MVP pour avoir un feedback rapide du client

Pour ma part, aujourd'hui, je prends le risque à faire du collaborative 
car il y a moins de concept à connaitre en faisant du collaborative.
Passer par cette étape d'apprentissage permet TDD rapidement et de comprendre les avantages que peut nous apporter le denouement

# Test end to end

Un test end to end est un test qui simule l'entrée et qui passe par tous les adapteurs (class d'implémentation).

# Pyramide des tests

donner un pourcentage de coverage de vos différents tests.

# Des concepts pour faciliter le developpement

- Container de dépendance
- autowire
- pyramide de tests