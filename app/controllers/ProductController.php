<?php
use Phalcon\Mvc\Controller;
use App\Models;
class ProductController extends ControllerBase
{
   
    public function indexAction()
    {
    }

    public function createAction()
    {
        $product = new Product();
        $brand = $this->request->getPost('brand');
        $title = $this->request->getPost('title');
        $product_image = $this->request->getPost('product_image');
        $product_prize = $this->request->getPost('product_prize');
        
        $product->title = $title;
        $product->blog_description = $blog_description;

        if ($this->request->hasFiles() == true) {
            foreach ($this->request->getUploadedFiles() as $file) {
                $Name = preg_replace("/[^A-Za-z0-9.]/", '-', $file->getName());
                $FileName = "public/img/blog/" . $Name;

                if (!$file->moveTo($FileName)) {
                    $this->flashSession->warning("An error occurred while uploading the document.");
                }
            }
            $blog->blog_image = $Name;
        }

        if (!$blog->save()) {
            $this->flashSession->error("The form is empty.");
            $this->view->disable();
            $this->response->redirect("blog");
        }
        else {
            $this->flashSession->success('Blog data successfully updated.');

            $this->response->redirect("blog");
        }
    }
    
}