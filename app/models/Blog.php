<?php
use Phalcon\Validation;
use Phalcon\Paginator\Adapter\QueryBuilder as PaginatorQueryBuilder;

class Blog extends \Phalcon\Mvc\Model

{
    public $id;
    public $title;
    public $blog_description;
    public $blog_image;

    public function initialize()
    {
        // The model name and table name is different hence we set the source here Model=Blog, Table=Blogs
    //    $this->setSource("Blogs");
       
    }

}
