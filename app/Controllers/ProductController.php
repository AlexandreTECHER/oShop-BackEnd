<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends CoreController{

        /*
    * Affiche une liste de produits
    */
    public function list(){

        $products = Product::findAll();

        $this->show('product/list', [
            'list' => $products,
        ]);
    }

    public function add(){
        $this->show('product/add');
    }

    /**
     * Méthode gérant l'insertion d'un nouveau produit en BDD
     * 
     * @return bool
     */
    public function addPost(){

        global $router;

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $brandId = filter_input(INPUT_POST, 'brand', FILTER_VALIDATE_INT);
        $categoryId = filter_input(INPUT_POST, 'category', FILTER_VALIDATE_INT);
        $typeId = filter_input(INPUT_POST, 'type', FILTER_VALIDATE_INT);

        $product = new Product();
        $product->setName($name) ;
        $product->setDescription($description);
        $product->setPicture($picture);
        $product->setPrice($price);
        $product->setRate($rate);
        $product->setStatus($status);
        $product->setBrandId($brandId);
        $product->setCategoryId($categoryId);
        $product->setTypeId($typeId);

        $insertProduct = $product->insert();

        if($insertProduct){
            $redirect = $router->generate('product-list');
        }


        header('Location:' . $redirect);
    }
}