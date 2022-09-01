<?php

class CartController extends ControllerBase
{

    public function indexAction()
    {

    }
    public function cartAction()
    {
        $prod_id = intval($this->request->get('prod_id'));
        $data = Product::findFirst('prod_id=' . $prod_id);
        $product = $data->toArray();
        return $this->response->setJsonContent($product);
    }

}