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
                    $this->flashSession->error("An error occurred while uploading the document.");
                }
            }
            $blog->blog_image = $Name;
            $blog->save();
            $this->flashSession->success('Company successfully updated.');
            $this->response->redirect("blog");
            $this->view->disable();
        }
    }
    public function landingAction()
    {
    }

}
