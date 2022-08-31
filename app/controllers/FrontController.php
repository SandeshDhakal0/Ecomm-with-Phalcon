<?php
use \Phalcon\Tag;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\View;
use App\Models;
use Phalcon\Paginator\Adapter\NativeArray;
use Phalcon\Mvc\Model;


class FrontController extends ControllerBase
{
    public function initialize()
    {
        $page = $_GET['page'] ?? 1;
        $data = Product::find()->toArray();

        $currentPage = $page;
        $paginator = new NativeArray(
        [
            "data" => $data,
            "limit" => 4,
            "page" => $currentPage,
        ]);
           
        $paginate = $paginator->paginate();
        //  echo "<pre>";
        //  var_dump($paginate);
        //  echo "<pre>";
        //  die();

        $this->view->blog = $paginate;
    }
   
    public function indexAction()
    {
        $prod = Product::find();
        $this->view->setVar('product',$prod);
    }


    public function womensdressAction()
    {
        $prod = Product::find();
        $this->view->setVar('product',$prod);
        
    }

    public function blogAction()
    {
        $data = Blog::find();
        $this->view->blog = $data; 
    }

    public function cartAction()
    {
      echo "this is the cart";
    }
    
}