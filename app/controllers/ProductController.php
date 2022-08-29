<?php
use Phalcon\Mvc\Controller;
use App\Models;
class ProductController extends ControllerBase
{

    public function indexAction()
    {
        $prod = new Product();
        $result = $prod->allCategory();
        $this->view->setVar('category', $result);
    }

    public function createAction()
    {
        if ($this->request->isAjax()) {
            $product = new Product();
            $product->brand = $this->request->getPost('brand');
            $product->title = $this->request->getPost('title');
            $product->prod_price = $this->request->getPost('prod_price');
            $product->prod_description = $this->request->getPost('prod_description');
            $product->size = json_encode($this->request->getPost('size'));
            $product->cat_id = $this->request->getPost('cat_id');
            $img = array();
            $i = 0;
            if ($this->request->hasFiles() == true) {
                foreach ($this->request->getUploadedFiles() as $file) {
                    $Name = preg_replace("/[^A-Za-z0-9.]/", '-', $file->getName());
                    $FileName = "public/img/product/" . $Name;
                    $img[$i++] = $Name;
                    if (!$file->moveTo($FileName)) {
                        $this->flashSession->warning("An error occurred while uploading the document.");
                    }
                }
                $product->product_image = json_encode($img);
            }
            if ($product->save() === false) {
                $messages = $product->getMessages();

                $errorMsg = 'Not working';
                foreach ($messages as $message) {
                    $errorMsg . "{$message} <br>";
                }
            }
            else {
                return $this->response->setJsonContent("success");
            }
        }
    }

    public function showAction()
    {
        $product = Product::find();
        $products = $product->toArray();
        $finalproduct = array();
        foreach ($products as $prod) {
            $res = new Product();
            $cat = $res->findCategoryById($prod['cat_id']);
            $prod['cat_id'] = $cat['cat_name'] . '-' . $cat['cat_cat'];
            $finalproduct[] = $prod;
        }
        $this->view->setVar('prod', $finalproduct);
    }

    public function editAction()
    {  
        $prod_id = $this->getUrlSegment(1);
        if(!empty($prod_id) AND $prod_id != null)
        {
            $category = new Product();
            $cat = $category->allCategory();        
            $product = $category->findProductId($prod_id);         
            if(!$prod_id){
                $this->flashSession->error('Product was not found.');
                return $this->response->redirect('product/create');
            }
            $this->view->setVar('category',$cat);
            $this->view->product = $product;
        } else {
            $product = new Product();
            $product->prod_id = $this->request->getPost('prod_id');
            $product->brand = $this->request->getPost('brand');
            $product->title = $this->request->getPost('title');
            $product->prod_price = $this->request->getPost('prod_price');
            $product->prod_description = $this->request->getPost('prod_description');
            $product->size = json_encode($this->request->getPost('size'));
            $product->cat_id = $this->request->getPost('cat_id');
            $prod2 = $product->findProductId($this->request->getPost('prod_id'));
            $img = array();
            $i = 0;
        
            if ($this->request->hasFiles() == true) {
                $imgs = json_decode($prod2['product_image']);
                foreach($imgs as $fetchImgTitleName){
                    $createDeletePath = "public/img/product/".$fetchImgTitleName;
                   unlink($createDeletePath);

                }
                
                foreach ($this->request->getUploadedFiles() as $file) {
                    $Name = preg_replace("/[^A-Za-z0-9.]/", '-', $file->getName());
                    $FileName = "public/img/product/" . $Name;
                    $img[$i++] = $Name;
                    // var_dump($file->moveTo($FileName));
                    if (!$file->moveTo($FileName)) {
                        $this->flashSession->warning("An error occurred while uploading the document.");
                    }
                }
                // die();
                $product->product_image = json_encode($img);
            }else{
                $product->product_image = $prod2['product_image'];
            }
            $product->created_at = $prod2['created_at'];
            $product->updated_at = date('Y-m-d H:i:s');
            if ($product->update() === false) {
                $messages = $product->getMessages();
                $errorMsg = 'Not working';
                foreach ($messages as $message) {
                    $errorMsg . "{$message} <br>";
                }
            }
            else {
                 
                 return $this->response->setJsonContent(
                    'success'
                 );            
            }
        }
    }

    public function deleteAction($id)
    {
        $prod = new Product();
        $product = $prod->findProductId($id); 
        // $products = $prod->toArray();
    //     $imgs = json_decode($product['product_image']);
    // foreach($imgs as $fetchImgTitleName){
    //    $createDeletePath = "public/img/product/".$fetchImgTitleName;
    //    unlink($createDeletePath);
     if($product){
        $product->delete();
        $this->session->destroy();
       $this->response->redirect("/product/show");
    }  
      echo "The product is not found"; 
    }
}
