<?php
declare(strict_types = 1)
;


class BlogController extends ControllerBase
{
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
           
            if (!$blog->save())
            {
                $this->flashSession->error("The form is empty.");
                $this->view->disable();
                $this->response->redirect("blog");
            }else{
                $this->flashSession->success('Blog data successfully updated.');
                
                $this->response->redirect("blog");
            }
            
            
            
        
    }
    public function showAction()
    {
        
        
    }

}
