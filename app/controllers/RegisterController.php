<?php

/**
 * SessionController
 *
 * Allows to register new users
 */
class RegisterController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    /**
     * Action to register a new user
     */
    public function indexAction()
    {

        $form = new RegisterForm;

        if ($this->request->isPost()) {

            $name = $this->request->getPost('name', array('string', 'striptags'));
            $email = $this->request->getPost('email', 'email');
            $cpf = $this->request->getPost('cpf', array('string', 'striptags'));
            $data_nas = $this->request->getPost('data_nas');
            $password = $this->request->getPost('password');
            $repeatPassword = $this->request->getPost('repeatPassword');

            if ($password != $repeatPassword) {
                $this->flash->error('As senhas são diferentes');
                return false;
            }
            
            $user = new Pessoa();

            $user->senpes = md5($password);
            $user->nompes = $name;
            $user->emapes = $email;
            $user->cpfpes = $cpf;
            $user->datanaspes = $data_nas;
            if ($user->save() == false) {
                foreach ($user->getMessages() as $message) {
                    $this->flash->error((string) $message);
                }
            } else {
                $this->tag->setDefault('email', '');
                $this->tag->setDefault('password', '');
                $this->flash->success('Obrigado por se inscrever, faça o login para começar a responder e criar seus Peers!!');

                return $this->dispatcher->forward(
                    [
                        "controller" => "session",
                        "action"     => "index",
                    ]
                );
            }
        }

        $this->view->form = $form;
    }
}
