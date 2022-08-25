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
            // $brand = $this->request->getPost('brand');
            // $title = $this->request->getPost('title');
            // $prod_price = $this->request->getPost('prod_price');
            // $product_image = $this->request->getPost('image');
            // $prod_description = $this->request->getPost('prod_description');
            // $size = json_encode($this->request->getPost('size'));
            // $cat_id = $this->request->getPost('cat_id');
            $product->brand = $this->request->getPost('brand');
            $product->title = $this->request->getPost('title');
            ;
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
}
