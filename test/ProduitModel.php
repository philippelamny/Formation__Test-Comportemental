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