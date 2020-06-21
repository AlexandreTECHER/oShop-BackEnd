<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController{

    /*
    * Affiche une liste de catégorie
    */
    public function list(){

        $category = Category::findAll();

        $this->show('categories/list', [
            'list' => $category,
        ]);
    }

    public function add(){
        $this->show('categories/add',[
            'category' => new Category()
        ]);
    }

    public function addPost(){

        global $router;

        if(filter_input(INPUT_POST, 'name')){

            $name = $_POST['name'];
        };

        if(filter_input(INPUT_POST, 'subtitle')){

            $subtitle = $_POST['subtitle'];
        };

        if(filter_input(INPUT_POST, 'picture')){

            $picture = $_POST['picture'];
        };

        $category = new Category();
        $category->setName($name);
        $category->setSubtitle($subtitle);
        $category->setPicture($picture);

        $success = $category->insert();

        if($success){
            $redirect = $router->generate('categories-list');
        }else{
            $redirect = $router->generate('category-add');
        }
        header('Location: ' . $redirect);
        exit();
        
    }

    public function update($categoryId){

        $updateCategory = Category::find($categoryId);

        $this->show('categories/add',[
            'category' => $updateCategory,
        ]);
    }

    public function updatePost($categoryId){

        $name = filter_input(INPUT_POST, 'name');
        $subtitle = filter_input(INPUT_POST, 'subtitle');
        $picture = filter_input(INPUT_POST, 'picture');

        $updateCategory = Category::find($categoryId);
        $updateCategory->setName($name);
        $updateCategory->setSubtitle($subtitle);
        $updateCategory->setPicture($picture);
        $updateCategory->update();

        $this->show('categories/add',[
            'category' => $updateCategory,
        ]);
    }
}