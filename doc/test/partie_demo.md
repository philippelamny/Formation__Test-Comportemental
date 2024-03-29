# Typologie

Dans le cas pratique, nous allons utiliser les typologies suivants:
- notre DTO d'entrée s'appellera Command
- notre Objet sera CommandHandler
- Les objets métiers seront des Models
- Les dépendances seront des services

# Cas d'utilisation:

En tant qu'administrateur du site, je souhaite pouvoir créer un produit.

Ce produit aura les propriétés suivantes:
- Nom du produit (obligatoire et unique)
- Catégorie du produit (obligatoire, énumeration: volley, foot, natation, badminton)
- Description

Si l'un des champs obligatoire n'est pas rempli ou qui n'est pas valide, le produit ne peut être créé et l'administrateur doit en être informé.

Lors que le produit est créé, l'administrateur va etre redirigé vers la page qui liste les produits par ordre de date de création décroissant

Analyse du cas d'utilisation

# Live coding

## Étape 1 : création de la "command" ayant les propriétés demandées.

### Creation class CreationProduitCommandHandlerTest

### Creation Methode testInstanciationCreationProduitCommand

### On instancie la commande avec des valeurs Obligatoire et description

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

### On lance le test, ça plante => Concept du Red Green Refacto (Baby step)

### Grace à l'éditeur, nous pouvons générer les class automatiquement.

Le plus important et le plus dur est de trouver le bon namespace / naming qui fit bien avec le cas d'utilisation
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

## Etape 2 : instanciation du commandHandler

### test : instanciationCreationProduitCommandHandler

```php
class CreationProduitCommandHandlerTest extends TestCase
{

    // .................
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
}
```

### Creation automatique de la class handler pour faire passer au green

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

### setup de la classe de test avec l'instance de la commandeHandler en private.
Cela va permettre de gérer les dépendances qu'à un seul endroit.

```php

class CreationProduitCommandHandlerTest extends TestCase
{
    // .....
    protected function setUp(): void
    {
        parent::setUp();
        $this->creationProduitCommandeHandler = new CreationProduitCommandHandler();
    }
    //.....
}
```

==> Alt + enter sur creationProduitCommandeHandler pour générer la prop en private

```php
class CreationProduitCommandHandlerTest extends TestCase
{
    // ....
    private CreationProduitCommandHandler $creationProduitCommandeHandler;
    // .....
}
```

## Etape 3 : methode handle qui retour un model

Attention à ne pas confondre l'objet model avec l'objet model de Eloquent et l'entity de doctrine.
L'object model est representatif des informations liées aux spécifications métier!
Souvent, le repository gere l'intéraction avec la base de donnée et renvoie une collection de model ou un model.
Rajoutons notre handle qui prend en parametre la command et en retour, un ProduitModel

Les suffixes command, commandHandler, Model ne sont généralement pas utiles. En équipe, il est important de se mettre d'accord sur la nomenclature

```php

class CreationProduitCommandHandlerTest extends TestCase
{
    // .....
    /**
     * @test
     */
    public function handleWithCommandAndReturnProduitModel(): void
    {
        $expectedName = "NomDuProduit";
        $expectedCategorie = "volley";
        $expectedDescription = "description du produit";

        // Concept du DTP
        $command = new CreationProduitCommand(
            nom: $expectedName,
            categorie: $expectedCategorie
        );
        $command->description = $expectedDescription;
        $model = $this->creationProduitCommandeHandler->handle($command);
        
        $this->assertInstanceOf(ProduitModel::class, $model);
    }
    //.....
}
```

### Creation automatique du model

```php
<?php


namespace Trung\Ftc\Test;


class ProduitModel
{
} 
```

### Creation automatique de la methode handle

```php
class CreationProduitCommandHandler
{

    /**
     * CreationProduitCommandHandler constructor.
     */
    public function __construct()
    {
    }

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        return new ProduitModel();
    }
}
```

## Etape 4 : Injection Presenteur

Cette partie est vraiment optionelle. Elle palie à des soucis de performance

## Principe du Presenteur

C'est une abstraction permettant de retourner différent type de données pour le meme cas d'utilisation en fonction du device et type de retour.
C'est le principe du "O" Open/close du SOLID. Ouvert à l'évolution et fermé à la modification
Ici, le présenteur sera une sorte de container qui aura comme contrat, une methode permettant de renseigner le model et une méthode qui retournera de la data à renvoyer dans l'action du controller

## Injection de dépendance

Avec le presenteur, la commandHandler ne sera plus obligée de retourner un object.
En effet, on va injecter la dependance du présenteur dans le constructeur du handler.
Dans la methode handle, on affectera le model au présenteur.

## Inversion de dépendance

Le principe d'inversion de dépendance est très simple et utilisé sans connaitre le principe.
Le but est de pouvoir faire travailler un objet sans connaitre la nature de l'implémenteur avec une abstraction contenant des contracts.
En fait, ça consiste à injecter la dependance avec une interface.

### Injecter une instance du presenteur JSON Dans le setup et le test de creation du handler,

#### Modifier le test d'instanciation du handler

```php
    public function instanciationCreationProduitCommandHandler(): void
    {
        $presenter = new CreationProduitJsonPresenteur();
        $handler = new CreationProduitCommandHandler($presenter);

        $this->assertInstanceOf(CreationProduitCommandHandler::class, $handler);
    }
```

#### Modifier le setup avec une instanciation du handler en prop

```php

    private CreationProduitJsonPresenteur $creationProduitPresenter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creationProduitPresenter = new CreationProduitJsonPresenteur();
        $this->creationProduitCommandeHandler = new CreationProduitCommandHandler($this->creationProduitPresenter);
    }
```

#### Creation de la class CreationProduitJsonPresenteur

```php
<?php

namespace Trung\Ftc\Test;

class CreationProduitJsonPresenteur
{
    
}
```

#### Ajout le parametre du presenteur dans le construct du handler

```php
<?php


namespace Trung\Ftc\Test;


class CreationProduitCommandHandler {
    
    public function __construct(private CreationProduitJsonPresenteur $creationProduitPresenter)
    {
    }
        
    //.................
}
```

================> On vient d'injecter la dependance. Maintenant, nous allons interfacer le presenteur

#### Creation de l'interface CreationProduitPresenteur
Faire implémenter CreationProduitJsonPresenteur sur cette nouvelle class avec comme contrat une methode permettant de spécifier le model
L'autre méthode n'est pas encore utilisée. Le TDD, va nous permettre de coder le moins possible pour valider le comportement

```php
<?php 
// CreationProduitJsonPresenteur.php

namespace Trung\Ftc\Test;

class CreationProduitJsonPresenteur implements CreationProduitPresenteur
{

}

// CreationProduitPresenteur.php

namespace Trung\Ftc\Test;


interface CreationProduitPresenteur
{

}

```
##### Dans le handler, on affecte le model au presenteur

```php

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        $model = new ProduitModel();
        $this->creationProduitPresenter->affecteModel($model);
        return $model;
    }
```

```php

namespace Trung\Ftc\Test;

class CreationProduitJsonPresenteur implements CreationProduitPresenteur
{

    public function affecteModel(ProduitModel $model): array
    {
        return [];
    }
}
```

##### On change la signature du présenteur avec l'interface

```php
    public function __construct(private CreationProduitPresenteur $creationProduitPresenter)
    {
    }
```

##### On ajoute le contrat

```php
namespace Trung\Ftc\Test;

interface CreationProduitPresenteur
{
    public function affecteModel(ProduitModel $model): array;
}
```

## Etape 5 : gestion des contraintes :  Insertion des erreurs

### 5.1 Test Unicité du nom

Ce test va nous conduire à créer:
- le répository (interface) qui va nous permettre de faire la vérification avec une fonction dans le handler
- On mockera l'interface et l'implémentation du repo se fera de manière indépendante.
- Gestion d'exception

#### Creation d'un nouveau test qui permet de vérifier l'unicité et l'erreur renvoyée.


```php
    /**
     * @test 
     */
    public function creationNouveauProduitAvecUnNomExistant(): void
    {
        $existingName = "Trungproduit";
        $cat = "volley";
        $command = new CreationProduitCommand(
            nom: $existingName,
            categorie: $cat
        );

        $this->expectExceptionCode("500");

        $this->creationProduitCommandeHandler->handle($command);

    }
```

#### Implementation dans le handler la verification

```php

class CreationProduitCommandHandler {
    
    public function __construct(
        private CreationProduitPresenteur $creationProduitPresenter,
        private ProduitRepository $produitRepository,
    )
    {
    }

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        if ($this->produitRepository->isExist($command->nom)) {
            throw new \Exception("produit déjà existant", 500);
        }

        $model = new ProduitModel();
        $this->creationProduitPresenter->affecteModel($model);
        return $model;
    }
} 
```

#### Creation l'interface ProduitRepository et du contrat isExist

```php
<?php

namespace Trung\Ftc\Test;

interface ProduitRepository
{

    public function isExist(string $nom): bool;
}
```

#### Creation Mock ProduitRepository et l'injecter dans le constructeur du setup

Dans cette partie, il aurait été préférable d'injecter dans le constructeur du setup avant de creer l'interface.
Il arrive qu'on bypass certaine étape pour faciliter la vie.

```php
    // ......
    private ProduitRepository             $produitRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->creationProduitPresenter = new CreationProduitJsonPresenteur();
        $this->produitRepository = $this->createMock(ProduitRepository::class);
        $this->creationProduitCommandeHandler = new CreationProduitCommandHandler(
            creationProduitPresenter: $this->creationProduitPresenter,
            produitRepository: $this->produitRepository
        );
    }
    // ...........
```

#### Mock le retour de la fonction isExist

```php
    /**
     * @test 
     */
    public function creationNouveauProduitAvecUnNomExistant(): void
    {
        // On mock le retour pour simuler le comporter de l'interface en exist
        $this->produitRepository->method('isExist')->willReturn(true);
        $existingName = "Trungproduit";
        $cat = "volley";
        $command = new CreationProduitCommand(
            nom: $existingName,
            categorie: $cat
        );

        $this->expectExceptionCode("500");

        $this->creationProduitCommandeHandler->handle($command);

    }
```

#### Suppression test inutile

Si vous relancez l'ensemble des tests, il y a le test instanciationCreationProduitCommandHandler qui va etre en erreur.
Ce test nous servait juste à creer la class CommandHandler. Il n'est plus utilise de laisser executer et maintenir ce test.
On peut le supprimer pour diminuer le cout.

### 5.2 Test Champs obligatoire

Cette partie peut etre faite de différente manière:
- depuis le controller
- depuis un middleware pour les openApi
- directement dans la commande (version simple mais plutot dans un value object (notion en DDD))
- dans le handler (Comme ici)

#### 5.2.1 Test champs nom vide

##### creation test creationNouveauProduitSansNom

On ne teste pas le null car sinon on teste le typage!

```php
    /**
     * @test
     */
    public function creationNouveauProduitSansNom(): void
    {
        $emptyName = "";
        $cat = "volley";
        $command = new CreationProduitCommand(nom: $emptyName, categorie: $cat);

        $this->expectExceptionCode("7000");

        $this->creationProduitCommandeHandler->handle($command);
    }
```

##### implémentation de l'erreur dans le handler
/!\ n'oublie pas le Red Green (Refacto) !! Le red green pour permet de valider que votre test est utile

```php
class CreationProduitCommandHandler {
    //.....
    
    public function handle(CreationProduitCommand $command): ProduitModel
    {
        if(empty($command->nom)) {
            throw new \Exception("le nom du produit doit etre spécifié", 7000);
        }
        // ......
    }
}
```


#### 5.2.2 Test champs categorie vide

##### creation test creationNouveauProduitSansCategorie

```php
    /**
     * @test
     */
    public function creationNouveauProduitSansCategorie(): void
    {
        $name = "nouveauProduit";
        $cat = "";
        $command = new CreationProduitCommand(nom: $name, categorie: $cat);

        $this->expectExceptionCode("7001");

        $this->creationProduitCommandeHandler->handle($command);
    }
```

##### implémentation de l'erreur dans le handler

```php
    public function handle(CreationProduitCommand $command): ProduitModel
    {
        // ......
        if (empty($command->categorie)) {
            throw new \Exception("la catégorie doit être spécifiée", 7001);
        }
        // ......
    }
```

#### 5.2.2 Test champs categorie inconnue

##### creation test creationNouveauProduitAvecCategorieInconnue

```php
    /**
     * @test 
     */
    public function creationNouveauProduitAvecCategorieInconnue(): void
    {
        $name = "nouveauProduit";
        $cat = "categorieIncoonnue";
        $command = new CreationProduitCommand(nom: $name, categorie: $cat);

        $this->expectExceptionCode("7002");

        $this->creationProduitCommandeHandler->handle($command);
    }
```

##### implémentation de l'erreur dans le handler

```php

class CreationProduitCommandHandler {

    public const CATEGORIES_LISTES = [
        'volley', 'foot', 'natation', 'badminton'
    ];

    // ......

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        //.....
        if (empty($command->categorie)) {
            throw new \Exception("la catégorie doit être spécifiée", 7001);
        }

        if (!in_array($command->categorie, static::CATEGORIES_LISTES)) {
            throw new \Exception("La catégorie renseignée n'est pas trouvée", 7002);
        }
        // .....
    }
}
```

Nous pouvons écrire un test permettant de valider si la catégorie existe mais dans notre context, c'est déjà testé par transitivité (par d'autres tests)
Nous pouvons aussi faire un test pour certifier que notre liste ne change pas! c'est à l'équipe d'en décider.

## Etape 6 : Creation du produit

### Creation creationNouveauProduitSaveCalled

```php
    /**
     * @test 
     */
    public function creationNouveauProduitSaveCalled(): void
    {
        $name = "nouveauProduit";
        $cat = "volley";
        $command = new CreationProduitCommand(nom: $name, categorie: $cat);

        $this->produitRepository->expects(static::once())->method('save');

        $this->creationProduitCommandeHandler->handle($command);
    }
```

### implementer le save dans le handle

```php
public function handle(CreationProduitCommand $command): ProduitModel
    {
        //......
        if ($this->produitRepository->isExist($command->nom)) {
            throw new \Exception("produit déjà existant", 500);
        }
        $this->produitRepository->save($command->nom, $command->categorie, $command->description);
        //......
    } 
```

### Ajouter le contract à l'interface

```php
<?php

namespace Trung\Ftc\Test;

interface ProduitRepository
{

    public function isExist(string $nom): bool;

    public function save(string $nom, string $categorie, string $description);
}
```

### Relance le test, et ça devrait passer

On peut zapper cette étape en faisant directement le code suivant le contrat de la méthode save qui retourne le produitModel et les assertions qui vont bien.
Mais cela fait beaucoup plus de code avant de pouvoir passer notre test au vert. Le but du TDD est de faire des baby step pour valider au plus vite et de maniere minimaliste notre test.

### Creation creationNouveauProduitSaved

```php
    /**
     * @test
     */
    public function creationNouveauProduitSaved(): void
    {
        $expectedName = "nouveauProduit";
        $expectedCat = "volley";
        $expectedDescription = "description";
        $command = new CreationProduitCommand(nom: $expectedName, categorie: $expectedCat, description: $expectedDescription);

        $this->produitRepository
            ->expects(static::once())
            ->method('save')
            ->willReturn(
                new ProduitModel(
                    nom: $expectedName,
                    categorie: $expectedCat,
                    description: $expectedDescription
                )
            );

        $model = $this->creationProduitCommandeHandler->handle($command);

        $this->assertEquals($expectedName, $model->nom);
        $this->assertEquals($expectedCat, $model->categorie);
        $this->assertEquals($expectedDescription, $model->description);
    }
```

### Mettre à jour le constructeur du ProduitModel

```php
<?php

namespace Trung\Ftc\Test;

class ProduitModel
{
    public function __construct(
        public string $nom,
        public string $categorie,
        public string $description = ""
    )
    {
    }
}
```

### Mettre à jour le handler pour que ça soit la méthode "save" du repo qui fournit le model du produit

```php
<?php


namespace Trung\Ftc\Test;


class CreationProduitCommandHandler {

    public const CATEGORIES_LISTES = [
        'volley', 'foot', 'natation', 'badminton'
    ];

    public function __construct(
        private CreationProduitPresenteur $creationProduitPresenter,
        private ProduitRepository $produitRepository,
    )
    {
    }

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        if(empty($command->nom)) {
            throw new \Exception("le nom du produit doit etre spécifié", 7000);
        }

        if (empty($command->categorie)) {
            throw new \Exception("la catégorie doit être spécifiée", 7001);
        }

        if (!in_array($command->categorie, static::CATEGORIES_LISTES)) {
            throw new \Exception("La catégorie renseignée n'est pas trouvée", 7002);
        }

        if ($this->produitRepository->isExist($command->nom)) {
            throw new \Exception("produit déjà existant", 500);
        }

        $model = $this->produitRepository->save($command->nom, $command->categorie, $command->description);

        $this->creationProduitPresenter->affecteModel($model);
        return $model;
    }
}
```

### Modifier la signature du contrat "save"

```php
<?php

namespace Trung\Ftc\Test;

interface ProduitRepository
{
    public function isExist(string $nom): bool;

    public function save(string $nom, string $categorie, string $description): ProduitModel;
}
```

## Relancer tous les tests et normalement tout est vert

En faisant de cette manière, nous avons la maitrise totale de notre cas d'utilisation.
Le code répond au besoin spécifié de manière unitaire, minimaliste et collaborative.



# Accès rapide
[accueil](../../README.md)
[Théorie](partie_theorique.md)
[Demo en TDD](partie_demo.md)
[Pratique du TDD](partie_pratique.md)
