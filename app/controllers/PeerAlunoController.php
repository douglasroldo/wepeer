<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PeerAlunoController extends ControllerBase {

    /**
     * Index action
     */
    public function indexAction($idpeer) {

        // $this->persistent->parameters = null;


        $perguntas = Pergunta::find(["codpee = $idpeer", "order" => "codper"]);

        $perguntasComOpcao = array();
        foreach ($perguntas as $pergunta) {
            $pergunta->opcoes = Opcao::find(["perguntacodper = $pergunta->codper", "order" => "codopc"]);
            $perguntasComOpcao[] = $pergunta;
        }

        $this->view->setParamToView(["pergunta" => $perguntasComOpcao]);
    }
    
    /**
     * Index action
     */
    public function responderAction($idpeer) {

        // $this->persistent->parameters = null;


        $perguntas = Pergunta::find(["codpee = $idpeer", "order" => "codper"]);

        $perguntasComOpcao = array();
        foreach ($perguntas as $pergunta) {
            $pergunta->opcoes = Opcao::find(["perguntacodper = $pergunta->codper", "order" => "codopc"]);
            $perguntasComOpcao[] = $pergunta;
        }

        $this->view->perguntas = $perguntasComOpcao;
    }

    /**
     * Searches for peeraluno
     */
    public function searchAction() {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'PeerAluno', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "peercodpee";

        $peeraluno = PeerAluno::find($parameters);
        if (count($peeraluno) == 0) {
            $this->flash->notice("The search did not find any peeraluno");

            $this->dispatcher->forward(array(
                "controller" => "peeraluno",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peeraluno,
            'limit' => 10,
            'page' => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction() {
        
    }

    /**
     * Edits a peeraluno
     *
     * @param string $peercodpee
     */
    public function editAction($peercodpee) {
        if (!$this->request->isPost()) {

            $peeraluno = PeerAluno::findFirstBypeercodpee($peercodpee);
            if (!$peeraluno) {
                $this->flash->error("peeraluno was not found");

                $this->dispatcher->forward(array(
                    'controller' => "peeraluno",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->peercodpee = $peeraluno->peercodpee;

            $this->tag->setDefault("peercodpee", $peeraluno->peercodpee);
            $this->tag->setDefault("alunocod_matricula", $peeraluno->alunocod_matricula);
            $this->tag->setDefault("datexecpeer", $peeraluno->datexecpeer);
        }
    }

    /**
     * Creates a new peeraluno
     */
    public function createAction() {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'index'
            ));

            return;
        }

        $peeraluno = new PeerAluno();
        $peeraluno->peercodpee = $this->request->getPost("peercodpee");
        $peeraluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peeraluno->datexecpeer = $this->request->getPost("datexecpeer");


        if (!$peeraluno->save()) {
            foreach ($peeraluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("peeraluno was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "peeraluno",
            'action' => 'index'
        ));
    }

    /**
     * Saves a peeraluno edited
     *
     */
    public function saveAction() {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'index'
            ));

            return;
        }

        $peercodpee = $this->request->getPost("peercodpee");
        $peeraluno = PeerAluno::findFirstBypeercodpee($peercodpee);

        if (!$peeraluno) {
            $this->flash->error("peeraluno does not exist " . $peercodpee);

            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'index'
            ));

            return;
        }

        $peeraluno->peercodpee = $this->request->getPost("peercodpee");
        $peeraluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peeraluno->datexecpeer = $this->request->getPost("datexecpeer");


        if (!$peeraluno->save()) {

            foreach ($peeraluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'edit',
                'params' => array($peeraluno->peercodpee)
            ));

            return;
        }

        $this->flash->success("peeraluno was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "peeraluno",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a peeraluno
     *
     * @param string $peercodpee
     */
    public function deleteAction($peercodpee) {
        $peeraluno = PeerAluno::findFirstBypeercodpee($peercodpee);
        if (!$peeraluno) {
            $this->flash->error("peeraluno was not found");

            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'index'
            ));

            return;
        }

        if (!$peeraluno->delete()) {

            foreach ($peeraluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peeraluno",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("peeraluno was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "peeraluno",
            'action' => "index"
        ));
    }

}
