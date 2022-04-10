# Qu'est-ce que c'est

Le test comportemental est un ensemble de test qui va décrire le comportement que l'on souhaite pour un cas d'utilisation donné.
Dans le trio des "D", nous retrouvons le BDD "Behavior Driven Developement". Un concept permettant de décrire tout un jeu d'exemple permettant de clarifier le cas d'utilisation.

# Pourquoi ?

Il va décrire l'ensemble des comportements décrits dans les spécifications "métiers" du cas d'utilisation.
De manière unitaire, tous les comportements doivent apparaître lors de l'exécution des tests.
Les noms des tests doivent être compréhensifs par Le métier.
Cela va permettre de créer de la documentation dynamique et vérifier si nous avons le comportement voulu.
Il n'est pas utile d'avoir tous les détails de l'implémentation dans le nom.
L'utilité des tests est d'avoir un garde fou sur les cas indésirables. Mais le plus important est de permettre la refactoriser du code.
Si les tests se basent sur l'aspect technique de l'implémentation, il sera difficile de maintenir la documentation car la technique reste du bas niveau et lors d'une refactorisation, on devra modifier le test (surtout les noms pour rester en adéquation avec la refacto), alors que le comportement n'est jamais censé changer.

Ex:
Bas niveau: then throw exception name already exist
Haut niveau: inform name already exist

Pensez au prochain collègue qui va passer sur vos tests. Il aura une meilleur compréhension du cas d'utilisation si les noms sont bien plus pertinent et correspondent à un comportement.
Il est important que les noms soient normalisés par l'équipe car comme pour le code, on ne doit pas distinguer le code de chacun (utopique)

# Pourquoi la refactorisation ?

Il y a un concept très utile pour travailler en équipe en toute bienveillance qui est "le code que tu as écrit à un instant T ne te représente pas".
Ce qui veut dire qu'il ne faut pas juger quelqu'un sur son code déjà ecrit car le programmeur évolue tous les jours et peut etre qu'à l'instant T, il y a eu un context qui fait que son code a été écrit ainsi.
La critique constructive sur le code et non le developpeur est nécessaire pour ainsi maintenir le code du systeme propre et maintenable au fil du temps.

**Le credo à avoir : Pousser votre code seulement lorsque vous en etes satisfaits!**

La refatoritsation peut etre complexe selon les fonctionnalités et du coup, etre très couteuse et risqués!
C'est là qu'il est important d'avoir des tests bons unitaires qui permettent de garantir la santé de votre systeme lors d'une refactorisation car elle ne doit pas modifier le comportement.

Lorsque vous avez du code legacy "Code sans test" et que vous avez besoin de faire evoluer le code (refacto ou evolution métier), c'est le moment idéal de mettre en place des tests sur le nouveau comportement ou/et des tests sur le comportement existants avant la refacto.

Des méthodologies peuvent vous aider à rendre vos codes organisés,  structures, compréhensifs et cohérents avec une validation en amont des normes architecturalles du système au sein de l'équipe.
Vous pouvez suivre :
- les recommandations de oncle bob (clean code)
- des design pattern pouvant répondre à des problématiques spécifiques ( singleton, factory abstract, chain of responsability, ...)
- le concept de S.O.L.I.D

Casser le code pour mieux le reconstruire ne devrait plus être une crainte mais un encouragement vers une meilleur qualité du système (optimisation et compréhension de l'intention du code)

# Raconter l'Histoire de oncle BOB sur l'acceptation d'avoir des tests écrits pas proprement mais d'avoir son code systeme complexe mais propre!

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
  Given When THEN
- Repeatable
- Self Validation
- Thorough : couverture de tous les cas et non 100% des données

# test unitaire

Concept du port / adpateur
Dans un test unitaire, on test le class object (cas d'utilisation) et on simule les ports (les interfaces des services)

# test d'intégration

Dans un test d'intégration, on choisit d'intégrer dans nos tests, un adapteur (class implémentation d'un ou pusieur service)


# Test end to end

Un test end to end est un test qui simule l'entrée et qui passe par tous les adapteurs (class d'implémentation).

# Pyramide des tests

Parmi les 3 types de tests (unitaire/integration/end to end),
Chacun des tests apportent une plus value au système mais aussi des inconvénients.

La pyramide des tests est un récapitulatif des avantages/inconvénients des trois types de test par leur complexité, temps de exécution, coût de mise en place et propose une repartition globale.

Les tests de bout en bout apporte une assurance sur la la fonctionalité du système mais seule, le code peut devenir une boîte noire et complexe à maintenir. Cest plus lent et olus coûteux car il faut déployer tout l'environnement pour que cela fonctionne.

Les tests d'intégration sont simple mais reste coûteux car il faut mettre en place des parties tierces à chaque test (ex : base de donnees) et les tests ne sont pas forcement testables en parallèle.

Les tests unitaires sont simples, efficaces et comprehensifs. Ils respectent l'acronyme du FIRST. Peu coûteux car ils se suffisent à eux même. Pas besoin d'une infrastructure robuste. Ils aident à la refactorisation de petit bout de code.
Avec un  coverage de 100% grace a des tests unitaires, vous vous assurez une qualité de code qui peut toujours être évolué proprement.


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


# Différents concepts à connaitre pour la demo / pratique

- concept de cas d'utilisation
- principe injection de dépendance par interface a la construction de l'objet
- principe inversion de dépendance
- test unitaire avec Phpunit et notion Mock

# Des concepts pour faciliter le developpement

- cqs
- Container de dépendance
- autowire
- pyramide de tests

# Accès rapide
[accueil](../../README.md)
[Théorie](partie_theorique.md)
[Demo en TDD](partie_demo.md)
[Pratique du TDD](partie_pratique.md)