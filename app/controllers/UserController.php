<?php 

class UserController extends \Phalcon\Mvc\Controller
{

 public function indexAction()
 {
    $this->view->setVars([
        'single'=> User::findFirstById(1),
        'all' => User::find([
            'deleted is NULL'
        ]),
    ]);
 }

 public function loginAction()
 {
     echo $this->filter->sanitize('50a',"int");
 }

 public function createAction()
 {
    $user = new User();
    $user->email ='test@test.com';
    $user->password ='test';
    $user->created_at = date("Y-m-d H:i:s");
    $result = $user->create();
    if(!$result){
        print_r($user->getMessages());
    }

 }  

 public function createAssocAction()
 {
    $user = User::findFirst(1);
    $project = new Project();
    $project->user = $user;
    $project->title = "Lucifer";
    $result = $project->save();
 }

 public function updateAction()
 {
    $user = User::findFirstById(3);
    if(!$user){
        echo "The user is not available.";
        die;
    }
    $user->email="update@test.com";
    $result = $user->update();
    if(!$result){
        print_r($user->getMessages());
    }
 }

 public function deleteAction()
 {
    $user = User::findFirstById(3);
    if(!$user){
        echo "User does not exist";
        die;
    }
    $result = $user->delete();
    if(!$result){
        print_r($user->getMessages());
    }
 }
 
}