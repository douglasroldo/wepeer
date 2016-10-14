<?php

class IndexController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Bem vindo !');
        parent::initialize();
    }

    public function indexAction()
    {
        if (!$this->request->isPost()) {
           
        }
    }
}
