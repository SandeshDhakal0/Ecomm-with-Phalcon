<?php
declare(strict_types=1);


class BlogController extends ControllerBase
{
    public function indexAction()
    {
        
    }

    public function createAction()
    {

        if($this->request->hasFiles() == true){
        
            $blog = new Blog();
            
            $title = $this->request->getPost('title');
            $blog_description = $this->request->getPost('desc');
            // $blog_image = $this->request->getPost('blog_image');die;
                $blog->title = $title;
                $blog->blog_description = $blog_description;
                $blog->blog_image = 'dummy.jpg';
                // var_dump($blog->save());die;
            if($blog->save()){
                echo "Success";
                die;
                // return $this->response->setJsonContent('Details added to the database.');
            }else{
                echo "Unable to proceed";
                die;
            }
    }
}
public function landingAction()
{

}

}

    



