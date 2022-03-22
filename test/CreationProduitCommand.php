<?php


namespace Trung\Ftc\Test;


class CreationProduitCommand
{
    public function __construct(
        public string $nom,
        public string $categorie,
        public string $description = ""
    )
    {
    }
}