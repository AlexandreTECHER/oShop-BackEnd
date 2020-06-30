<?php

namespace App\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Type;

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

        $brands = Brand::findAll();
        $category = Category::findAll();
        $types = Type::findAll();

        $this->show('product/add', [
            'product' => new Product(),
            'brands' => $brands,
            'categories' => $category,
            'types' => $types,
        ]);
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

    public function update($productId){

        global $router;

        $this->checkAuthorization(['admin', 'catalog-manager']); 
        
        $brands = Brand::findAll();
        $category = Category::findAll();
        $updateProduct = Product::find($productId);
        $types = Type::findAll();


        $this->show('product/add',[
            'brands' => $brands,
            'categories' => $category,
            'product' => $updateProduct,
            'types' => $types,
        ]);
    }

    public function updatePost($productId){

        global $router;

        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, 'status');
        $category = filter_input(INPUT_POST, 'category');
        $brand = filter_input(INPUT_POST, 'brand');
        $type = filter_input(INPUT_POST, 'type');

        $updateProduct = Product::find($productId);
        $updateProduct->setName($name);
        $updateProduct->setDescription($description);
        $updateProduct->setPicture($picture);
        $updateProduct->setPrice($price);
        $updateProduct->setRate($rate);
        $updateProduct->setStatus($status);
        $updateProduct->setCategoryId($category);
        $updateProduct->setBrandId($brand);
        $updateProduct->setTypeId($type);
        $update = $updateProduct->update();

        if($update){
            $redirect = $router->generate('product-list');
        }else{
            $redirect = $router->generate('product-update', ['productId' => $updateProduct->getId()]);
        }

        header('Location: ' . $redirect);

    }
}