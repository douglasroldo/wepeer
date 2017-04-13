<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class PeerController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle(' | Peer');
        parent::initialize();
    }

    /**
     * Index action
     */
    public function indexAction() {
        //$this->persistent->parameters = null;
        //echo "Bem vindo ";
        $this->view->form = new PeerForm;
    }

    /**
     * Searches for peer
     */
    public function searchAction() {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peer', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters ["order"] = "turmacodtur";

        $peer = Peer::find($parameters);
        if (count($peer) == 0) {
            $this->flash->notice("A busca não encontrou nenhum peer");

            $this->dispatcher->forward(array(
                "controller" => "peer",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peer,
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
     * Edits a peer
     *
     * @param string $turmacodtur
     */
    public function editAction($turmacodtur) {
        if (!$this->request->isPost()) {

            $peer = Peer::findFirstByturmacodtur($turmacodtur);
            if (!$peer) {
                $this->flash->error("Peer não foi encontrado");

                $this->dispatcher->forward(array(
                    'controller' => "peer",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->turmacodtur = $peer->turmacodtur;

            $this->tag->setDefault("turmacodtur", $peer->turmacodtur);
            $this->tag->setDefault("codpee", $peer->codpee);
            $this->tag->setDefault("despee", $peer->despee);
            $this->tag->setDefault("datcadpee", $peer->datcadpee);
            $this->tag->setDefault("dasexepee", $peer->dasexepee);
            $this->tag->setDefault("dasfimpee", $peer->dasfimpee);
        }
    }

    /**
     * Creates a new peer
     */
    public function createAction() {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'index'
            ));
            
            return;
        }

        $form = new PeerForm;
        $peer = new Peer();

        // Validate the form
        $data = $this->request->getPost();
        if (!$form->isValid($data, $peer)) {
            
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                            [
                                "controller" => "peer",
                                "action" => "new",
                            ]
            );
        }

        if (!$peer->save()) {
            foreach ($peer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("Peer foi criado com êxito");

        $this->dispatcher->forward(array(
            'controller' => "peer",
            'action' => 'index'
        ));
    }

    /**
     * Saves a peer edited
     *
     */
    public function saveAction() {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'index'
            ));

            return;
        }


        $form = new PeerForm;
        $peer = new Peer();

        /* $turmacodtur = $this->request->getPost("turmacodtur");
          $peer = Peer::findFirstByturmacodtur($turmacodtur);

          if (!$peer) {
          $this->flash->error("Peer não existe " . $turmacodtur);

          $this->dispatcher->forward(array(
          'controller' => "peer",
          'action' => 'index'
          ));

          return;
          }

          $peer->turmacodtur = $this->request->getPost("turmacodtur");
          $peer->despee = $this->request->getPost("despee");
          $peer->datcadpee = date("Y-m-d H:i:s");
          $peer->dasexepee = $this->request->getPost("dasexepee");
          $peer->dasfimpee = $this->request->getPost("dasfimpee"); */

        // Validate the form
        $data = $this->request->getPost();
        if (!$form->isValid($data, $peer)) {
            foreach ($form->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                            [
                                "controller" => "peer",
                                "action" => "new",
                            ]
            );
        }

        if (!$peer->save()) {
            foreach ($peer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'edit',
                'params' => array(
                    $peer->turmacodtur
                )
            ));

            return;
        }

        $this->flash->success("Peer foi atualizada com sucesso!");

        $this->dispatcher->forward(array(
            'controller' => "peer",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a peer
     *
     * @param string $turmacodtur
     */
    public function deleteAction($turmacodtur) {
        $peer = Peer::findFirstByturmacodtur($turmacodtur);
        if (!$peer) {
            $this->flash->error("Peer não foi encontrada");

            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'index'
            ));

            return;
        }

        if (!$peer->delete()) {

            foreach ($peer->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("Peer foi deletada com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "peer",
            'action' => "index"
        ));
    }

}
