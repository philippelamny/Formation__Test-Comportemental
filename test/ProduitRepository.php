<?php


namespace Trung\Ftc\Test;


interface ProduitRepository
{

    public function isExist(string $nom): bool;
}