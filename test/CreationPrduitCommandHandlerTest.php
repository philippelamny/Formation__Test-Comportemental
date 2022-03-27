<?php


namespace Trung\Ftc\Test;

use PHPUnit\Framework\TestCase;

class CreationPrduitCommandHandlerTest extends TestCase
{
    private CreationProduitCommandHandler $creationProduitCommandeHandler;
    private CreationProduitJsonPresenteur $creationProduitPresenter;
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

        // Concept du DTP
        $command = new CreationProduitCommand(
            nom: $expectedName,
            categorie: $expectedCategorie
        );
        $command->description = $expectedDescription;

        $this->assertEquals($expectedName, $command->nom);
        $this->assertEquals($expectedCategorie, $command->categorie);
        $this->assertEquals($expectedDescription, $command->description);
    }

    /**
     * Comme pour le précedent, ce test nous juste à creer notre handler
     * Le handler étant représentatif de notre cas d'utilisation
     * C'est donc ce handler qui sera testé unitairement
     * Apres le Green, on pourra le mettre dans le setup du test
     * @test
     */
    public function instanciationCreationProduitCommandHandler(): void
    {
        $presenter = new CreationProduitJsonPresenteur();
        $handler = new CreationProduitCommandHandler($presenter, $this->produitRepository);

        $this->assertInstanceOf(CreationProduitCommandHandler::class, $handler);
    }

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
}