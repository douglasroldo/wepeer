<?php

/**
 * SessionController
 *
 * Allows to authenticate users
 */
class SessionController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('Sign Up/Sign In');
        parent::initialize();
    }

    public function indexAction() {
        if (!$this->request->isPost()) {
            $this->tag->setDefault('email', 'demo@phalconphp.com');
            $this->tag->setDefault('password', 'phalcon');
        }
    }

    /**
     * Register an authenticated user into session data
     *
     * @param Users $user        	
     */
    private function _registerSession(Pessoa $user) {
        $this->session->set('auth', array(
            'codpes' => $user->codpes,
            'nompes' => $user->nompes
        ));
    }

    /**
     * This action authenticate and logs an user into the application
     */
    public function startAction() {
        if ($this->request->isPost()) {

            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $pessoa = Pessoa::findFirst(array(
                        "emapes = :email: AND senpes = :password:",
                        'bind' => array(
                            'email' => $email,
                            'password' => md5($password)
                        )
             ));
            if ($pessoa != false) {
                $this->_registerSession($pessoa);
                $this->flash->success('Bem-vindo ' . $pessoa->nompes);

                return $this->dispatcher->forward([
                            "controller" => "home",
                            "action" => "index"
                        ]);
            }

            $this->flash->error('E-mail ou senha inválidos!');
        }

        return $this->dispatcher->forward([
                    "controller" => "session",
                    "action" => "index"
                ]);
    }

    /**
     * Finishes the active session redirecting to the index
     *
     * @return unknown
     */
    public function endAction() {
        $this->session->remove('auth');
        $this->flash->success('Obrigado!');

        return $this->dispatcher->forward([
                    "controller" => "index",
                    "action" => "index"
                ]);
    }

    public function loginMobileAction() {
        $this->view->disable();

        /* $u = Users::findFirst ( array (
          "(email = :email: OR username = :email:) AND password = :password: AND active = 'Y'",
          'bind' => array (
          'email' => $usuario,
          'password' => sha1 ( $senha )
          )
          ) );
          var_dump($u); */

        if (true) {
            echo "1";
        } else {
            echo "0";
        }
    }

}
