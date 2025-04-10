<?php

namespace App\Data;

/**
 * Classe ListeProduits
 *
 * Cette classe contient une liste statique de produits avec leurs attributs.
 * Chaque produit est représenté par un tableau associatif avec les clés suivantes :
 * - nom : Le nom du produit.
 * - prix : Le prix du produit.
 * - quantite : La quantité disponible du produit.
 * - rupture : Indique si le produit est en rupture de stock (true) ou non (false).
 */
class ListeProduits
{
    /**
     * @var array Liste statique de produits.
     * Chaque produit est un tableau associatif contenant les clés "nom", "prix", "quantite" et "rupture".
     */
    static $mesProduits = [
        ["nom" => "imprimantes", "prix" => 700, "quantite" => 10, "rupture" => false],
        ["nom" => "cartouches encre", "prix" => 80, "quantite" => 50, "rupture" => false],
        ["nom" => "ordinateurs", "prix" => 1700, "quantite" => 3, "rupture" => false],
        ["nom" => "écrans", "prix" => 500, "quantite" => 100, "rupture" => false],
        ["nom" => "claviers", "prix" => 100, "quantite" => 10, "rupture" => true],
        ["nom" => "souris", "prix" => 5, "quantite" => 200, "rupture" => false],
    ];
}
