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
        // $page = $_GET['page'] ?? 1;
        // $data = Product::find()->toArray();

        // $currentPage = $page;
        // $paginator = new NativeArray(
        // [
        //     "data" => $data,
        //     "limit" => 4,
        //     "page" => $currentPage,
        // ]);
           
        // $paginate = $paginator->paginate();
        // //  echo "<pre>";
        // //  var_dump($paginate);
        // //  echo "<pre>";
        // //  die();

        // $this->view->blog = $paginate;
    }
   
    public function indexAction()
    {
        // $data = User::findFirst();
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
        $prod_id = intval($this->request->get('prod_id'));
        $data = Product::findFirst('prod_id=' . $prod_id);
        $product = $data->toArray();
       
        return $this->response->setJsonContent($product);
    }

    public function detailAction($id)
    {
        $prod_id = $id;
        $data = Product::findFirst('prod_id=' .$prod_id);
        $product = $data->toArray();
        $this->view->setVar('products',$product);
    }
    
}