# Formation Informelle sur les Tests Comportementaux

## Pre-requis:

- concept de cas d'utilisation
- autowirering
- cqs
- injection de dépendance par interface  a la construction de l'object
- test unitaire
- mock

## Qu est-ce que c'est?

Le test comportemental est un ensemble de test qui va décrire le comportement que l'on souhaite pour un cas d utilisation donnée.

## Pourquoi

Il va décrire l ensemble des comportements décrites dans les spécifications metiers du cas d'utilisation de manière unitaire.

De manière unitaire, tous les comportements doivent apparaître lors de l'exécution des tests.

Les noms des tests doivent être compréhensifs par Le métier.
Cela va permettre de créer des documentations dynamiques et vérifier si nous avons le comportement voulu.

Il n'est pas utile d'avoir tous les détails de l'implémentation dans le nom.

L'utilité des tests est d'avoir un garde fou sur les éventuels cas indésirables. Mais le plus important est de permettre de refactoriser le code. (Todo : les bienfaits de la refactorisation)

Si les tests se bases sur l'aspect technique de l'implémentation, il sera difficile de maintenant la documentation car la technique reste du bas niveau et lors d'une refactorisation, on devra modifier le test (surtout les noms pour tester en adéquation avec la refacto). Alors que le comportement n'est jamais censé changer.

### Ex:
Bas niveau: then throw exception name already exist
Haut niveai: inform name al ready exist

Pensez au prochain collègue qui va passer sur vos code de test. Il aura une meilleur compréhension du cas d'utilisation si les noms sont bien plus pertinent et correspond à un comportement.

Il est important que les noms soient normalisés par l'équipe car comme pour le code, on ne doit pas distinguer le code de chacun (utopique)

## Test unitaire

Il y a différents types de test (Integration, Unitaire, EndToEnd). 
Ici nous allons nous concentrer sur les unitaires, c'est à dire sur une class spécifique et notamment sur son comportement.
Ce qui veut dire qu'on ne test pas une structure (ex: data transfert object "DTO") mais un object (classe avec des regles métiers).

### Typologie

Dans le cas pratique, nous allonrs utiliser les typologies vuivants:
- notre DTO d'entrée s'appellera Command
- notre Object sera CommandHandler
- Les objects métiers seont des Models
- Les dépendances seont des services

## Cas pratique

Tout au long du cas pratique, nous introduirons des concepts utiles pour écrire des tests unitaires

### Cas de utilisation:

En tant que administrateur du site, je souhaite pouvoir créer un produit.

Ce produit aura les propriétés suivantes:
•  Nom du produit (obligatoire)
• Catégorie du produit (obligatoire, enumeration: volley, foot, natation, badminton)
• Description

Si l'un des champs obligatoire n'est pas rempli ou qui n'est pas valide, le produit ne peut être créé et l'administrateur doit en être informé.

Lors que le produit est créé, l'administrateur va etre redirigé vers la page qui liste les produits par ordre de date de création descroissant

Analyse du cas d'utilisation

### Étape 1 : création de la commande ayant les propriétés demandées. 


### Etape 2 : instanciation du commande handler


### Etape 3 : methode handler qui retour un model


### Etape 4 : Injection Presenteur

#### Pattern Presenteur
#### Injection de dépendance
#### Inversion de dépendance

### Etape 5 : Insertion des erreurs

#### Pourquoi commencer par les erreurs : ref clean code

### Etape 6 : Regle métier

#### Différence entre test unitaire et test d'intégration
#### Concept du mock
#### Container de dépencance

### Pyramide des tests


