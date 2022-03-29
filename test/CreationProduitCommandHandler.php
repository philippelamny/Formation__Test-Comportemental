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