<?php
use Phalcon\Validation;

use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class Product extends \Phalcon\Mvc\Model

{
    public $prod_id;
    public $brand;
    public $title;
    public $prod_price;

    public $product_image;

    public $prod_description;

    public $size;

    public $cat_id;


    
    public function findProductId($id){
        $this->setSource('product');
        $result = $this->find('prod_id='.$id);
        if($result){
            return $result->toArray()[0];
        }else
        return null;
    }
    public function allCategory(){
        $this->setSource('category');
        $result = $this->find();
        if($result){
            return $result->toArray();
        }else
        return null;
    }
    public function findCategoryById($cat_id){
        $this->setSource('category');
        $result = $this->find('cat_id='.$cat_id);
        if($result){
            return $result->toArray()[0];
        }else
        return null;
    }    

    public function saveProduct($data){
        $this->setSource('product');
        $this->save($data);
        if($this->save($data)==false){
            $this->getMessages();
            return false;
        }else{
            return $this->id;
        }
    }
}