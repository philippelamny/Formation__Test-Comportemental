
Laissons place à la pratique en peer programming.

# clone du projet

`git clone https://github.com/philippelamny/Formation__Test-Comportemental.git`

# Lancer les tests existants

- Configuration depuis phpstorm en utilisant le container ftcphp du docker-compose
- Commande docker avec le container spécifié dans le docker-compose :
`docker-compose run ftcphp php vendor/phpunit/phpunit/phpunit --bootstrap bootstrap.php --no-configuration test`

# Cas d'utilisation

En tant qu'administrateur du site, je souhaite pouvoir modifier un produit.

Nous pourrons modifier les propriétés suivantes du produit existant :
- Catégorie du produit (obligatoire, énumeration: volley, foot, natation, badminton)
  seulement si le produit n'a pas été mis dans un panier
- Description

Si l'une des conditions n'est pas remplie, le produit ne peut être modifié et l'administrateur doit en être informé.

# Tips

Mocker le service inconnu