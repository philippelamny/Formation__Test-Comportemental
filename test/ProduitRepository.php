<?php


namespace Trung\Ftc\Test;


interface ProduitRepository
{

    public function isExist(string $nom): bool;

    public function save(string $nom, string $categorie, string $description): ProduitModel;
}