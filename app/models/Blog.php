<?php
use Phalcon\Validation;

class Blog extends \Phalcon\Mvc\Model

{
    public $id;
    public $title;
    public $blog_description;
    public $blog_image;

    public function initialize()
    {
        // $this->setSchema("ecommerce");
       $this->setSource("Blogs");
    }


}
