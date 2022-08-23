<?php
declare(strict_types = 1)
;
use Phalcon\Mvc\Controller;
use App\Models;
use Phalcon\Paginator\Adapter\NativeArray;
use Phalcon\Di;
use Phalcon\Http\Request;

class BlogController extends ControllerBase
{

    public function initialize()
    {
        $this->blog = new Blog();
    }
    public function indexAction()
    {

    }

    public function createAction()
    {   
        $blog = new Blog();
        $title = $this->request->getPost('title');
        $blog_description = $this->request->getPost('desc');
        $blog->title = $title;
        $blog->blog_description = $blog_description;

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
    public function showAction()
    {
        $page = $_GET['page'] ?? 1;
        $data = Blog::find()->toArray();

        $currentPage = $page;
        $paginator = new NativeArray(
        [
            "data" => $data,
            "limit" => 2,
            "page" => $currentPage,
        ]);
           
        $paginate = $paginator->paginate();
        //  echo "<pre>";
        //  var_dump($paginate);
        //  echo "<pre>";
        //  die();

        $this->view->blog = $paginate;

    }

    public function editAction($id){

        if(!empty($id) AND $id != null)
        {
            $blog = Blog::findFirst([
                'conditions' => 'id = :1:' ,
                'bind' => [
                    '1' => $id
                ]
            ]);
            if(!$blog){
                $this->flashSession->error('Blog post was not found.');
                return $this->response->redirect('blog/create');
            }
            $this->view->blog = $blog;
        }
    }

    public function editsubmitAction()
    {
    
        // if (!$this->request->isPost()) {
        //     return $this->dispatcher->forward(
        //         [
        //             "controller" => "blog",
        //             "action"     => "edit",
        //         ]
        //     );
        // }
    
        // $id = $this->request->getPost("id");
        // $blog = Blog::findFirstById($id);
    
        // if (!$blog) {
        //     $this->flash->error(
        //         "blog does not exist"
        //     );
    
        //     return $this->dispatcher->forward(
        //         [
        //             "controller" => "blog",
        //             "action"     => "edit",
        //         ]
        //     );
        // }
    
        // $form = new Blog();
    
        // $data = $this->request->getPost();
    
        // // if (!$form->isValid($data, $blog)) {
        // //     $messages = $form->getMessages();
    
        // //     foreach ($messages as $message) {
        // //         $this->flash->error($message);
        // //     }
    
        // //     return $this->dispatcher->forward(
        // //         [
        // //             "controller" => "blog",
        // //             "action"     => "create",
        // //         ]
        // //     );
        // // }
    
        // if ($blog->save() === false) {
        //     $messages = $blog->getMessages();
    
        //     foreach ($messages as $message) {
        //         $this->flash->error($message);
        //     }
    
        //     return $this->dispatcher->forward(
        //         [
        //             "controller" => "blog",
        //             "action"     => "edit",
        //         ]
        //     );
        // }
    
        // $form->clear();
    
        // $this->flash->success(
        //     "Product was updated successfully"
        // );
    
        // return $this->dispatcher->forward(
        //     [
        //         "controller" => "blog",
        //         "action"     => "index",
        //     ]
        // );
        $id = $this->request->getPost('id');
        $blog = Blog::findFirstById($id);
        $title = $this->request->getPost('title');
        $blog_description = $this->request->getPost('desc');
        $blog->title = $title;
        $blog->blog_description = $blog_description;

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
