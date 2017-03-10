<?php

class AboutController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('| Sobre');
        parent::initialize();
    }

    public function indexAction()
    {
    }
}
