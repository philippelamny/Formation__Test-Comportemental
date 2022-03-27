<?php


namespace Trung\Ftc\Test;


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