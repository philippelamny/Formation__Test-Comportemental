# Formation Informelle sur les Tests Comportementaux

## Pre-requis:

- concept de cas d'utilisation
- autowirering
- cqs
- injection de dépendance par interface a la construction de l'object
- test unitaire
- mock

## Qu est-ce que c'est

Le test comportemental est un ensemble de test qui va décrire le comportement que l'on souhaite pour un cas d utilisation donnée.
Dans le trio des "D", nous retrouvons le BDD "Behavior Driven Developement". Un concept permettant de décrire tout un jeu d'exemples permettant de clarifier le cas d'utilisation.

## Pourquoi

Il va décrire l ensemble des comportements décrits dans les spécifications "métiers" du cas d'utilisation.

De manière unitaire, tous les comportements doivent apparaître lors de l'exécution des tests.

Les noms des tests doivent être compréhensifs par Le métier.

Cela va permettre de créer de la documentation dynamique et vérifier si nous avons le comportement voulu.

Il n'est pas utile d'avoir tous les détails de l'implémentation dans le nom.

L'utilité des tests est d'avoir un garde fou sur les cas indésirables. Mais le plus important est de permettre la refactoriser du code. (Todo : les bienfaits de la refactorisation)

Si les tests se basent sur l'aspect technique de l'implémentation, il sera difficile de maintenir la documentation car la technique reste du bas niveau et lors d'une refactorisation, on devra modifier le test (surtout les noms pour rester en adéquation avec la refacto), alors que le comportement n'est jamais censé changer.

### Ex:
Bas niveau: then throw exception name already exist
Haut niveau: inform name already exist

Pensez au prochain collègue qui va passer sur vos tests. Il aura une meilleur compréhension du cas d'utilisation si les noms sont bien plus pertinent et correspondent à un comportement.

Il est important que les noms soient normalisés par l'équipe car comme pour le code, on ne doit pas distinguer le code de chacun (utopique)

## Test unitaire

Il y a différents types de test (Integration, Unitaire, EndToEnd). 
Ici nous allons nous concentrer sur les unitaires, c'est à dire sur une class spécifique et notamment sur son comportement.
Ce qui veut dire qu'on ne teste pas une structure (ex: data transfert object "DTO") mais un object (class avec des regles métiers).
Concept du FIRST

### Typologie

Dans le cas pratique, nous allons utiliser les typologies suivants:
- notre DTO d'entrée s'appellera Command
- notre Object sera CommandHandler
- Les objects métiers seront des Models
- Les dépendances seront des services

## Cas pratique

Tout au long du cas pratique, nous introduirons des concepts utiles pour écrire des tests unitaires

### Cas de utilisation:

En tant que administrateur du site, je souhaite pouvoir créer un produit.

Ce produit aura les propriétés suivantes:
- Nom du produit (obligatoire et unique)
- Catégorie du produit (obligatoire, enumeration: volley, foot, natation, badminton)
- Description

Si l'un des champs obligatoire n'est pas rempli ou qui n'est pas valide, le produit ne peut être créé et l'administrateur doit en être informé.

Lors que le produit est créé, l'administrateur va etre redirigé vers la page qui liste les produits par ordre de date de création descroissant

Analyse du cas d'utilisation

### Étape 1 : création de la "command" ayant les propriétés demandées. 

#### Creation class CreationPrduitCommandHandlerTest

#### Creation Methode testInstanciationCreationProduitCommand

#### On instancie la commande avec des valeurs Obligatoire et description

```php
<?php
namespace Trung\Ftc\Test;
use PHPUnit\Framework\TestCase;
class CreationPrduitCommandHandlerTest extends TestCase
{
    /**
     * Ce test est vraiment inutilie grace au paramètre nommé et au propriété public
     * Il nous sert juste de guide pour creer notre command
     * Ce test pourra etre supprimé apres que le test soit passé au vert ou bien etre modifié pour la suite
     * @test
     */
    public function instanciationCreationProduitCommand(): void
    {
        $expectedName = "NomDuProduit";
        $expectedCategorie = "volley";
        $expectedDescription = "description du produit";
        //Concept du DTP
        $command = new CreationProduitCommand(
            nom: $expectedName,
            categorie: $expectedCategorie
        );
        $command->description = $expectedDescription;
        $this->assertEquals($expectedName, $command->nom);
        $this->assertEquals($expectedCategorie, $command->categorie);
        $this->assertEquals($expectedDescription, $command->description);
    }
}
```

#### On lance le test, ça plante => Concept du Red Green Refacto

#### Grave à l'éditeur, nous pouvons générer les class automatiquement.

Le plus important et le plus dur est de trouver le bon namespace / naming qui fit bienavec le cas d'utilisation
=> Alt + enter  sur le nom de la command

```php
<?php
namespace Trung\Ftc\Test;
class CreationProduitCommand
{
    public function __construct(
        public string $nom,
        public string $categorie,
        public string $description = ""
    ) {}
}
```

### Etape 2 : instanciation du commandHandler

#### test : instanciationCreationProduitCommandHandler

```php
    /**
     * Comme pour le précedent, ce test nous juste à creer notre handler
     * Le handler étant représentatif de notre cas d'utilisation
     * C'est donc ce handler qui sera testé unitairement
     * Apres le Green, on pourra le mettre dans le setup du test
     * @test
     */
    public function instanciationCreationProduitCommandHandler(): void
    {
        $handler = new CreationProduitCommandHandler();
        $this->assertInstanceOf(CreationProduitCommandHandler::class, $handler);
    }
```

#### Creation automatique de la class handler pour faire passer au green

```php
<?php
namespace Trung\Ftc\Test;
class CreationProduitCommandHandler
{
    /**
     * CreationProduitCommandHandler constructor.
     */
    public function __construct()
    {
    }
}
```

#### setup de la classe de test avec l'instance de la commandeHandler en private.
Cela va permettre de gérer les dépendances qu'à un seul endroit.

```php  
    protected function setUp(): void
    {
        parent::setUp();
        $this->creationProduitCommandeHandler = new CreationProduitCommandHandler();
    }
```

==> Alt + enter sur creationProduitCommandeHandler pour générer la prop en private

```php
    private CreationProduitCommandHandler $creationProduitCommandeHandler;
```

### Etape 3 : methode handle qui retour un model

### Etape 4 : Injection Presenteur

### Principe du Presenteur

### Injection de dépendance

### Inversion de dépendance

### Etape 5 : gestion des contraintes :  Insertion des erreurs

### Etape 6 : Regle métier

### Différence entre test unitaire et test d'intégration

### Concept du mock

### Etape 7 : mock les différents services

### Test collaborative Vs Test denouement

### Etape 8 : gestion InMemory

### Container de dépendance

### Pyramide des tests

### Test end to end

### Etape 9 : test controller

### Possibilité de mettre en prod avec les tests de denouement grace au InMemory

