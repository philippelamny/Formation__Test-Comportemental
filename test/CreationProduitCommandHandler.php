<?php


namespace Trung\Ftc\Test;


class CreationProduitCommandHandler {

    public function __construct(private CreationProduitPresenteur $creationProduitPresenter)
    {
    }

    public function handle(CreationProduitCommand $command): ProduitModel
    {
        $model = new ProduitModel();
        $this->creationProduitPresenter->affecteModel($model);
        return $model;
    }
}