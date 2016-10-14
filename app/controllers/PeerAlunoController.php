<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeerAlunoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
                
    }

    /**
     * Searches for peer_aluno
     */
    public function searchAction()
    {
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

        $peer_aluno = PeerAluno::find($parameters);
        if (count($peer_aluno) == 0) {
            $this->flash->notice("The search did not find any peer_aluno");

            $this->dispatcher->forward(array(
                "controller" => "peer_aluno",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peer_aluno,
            'limit'=> 10,
            'page' => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a peer_aluno
     *
     * @param string $peercodpee
     */
    public function editAction($peercodpee)
    {
        if (!$this->request->isPost()) {

            $peer_aluno = PeerAluno::findFirstBypeercodpee($peercodpee);
            if (!$peer_aluno) {
                $this->flash->error("peer_aluno was not found");

                $this->dispatcher->forward(array(
                    'controller' => "peer_aluno",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->peercodpee = $peer_aluno->peercodpee;

            $this->tag->setDefault("peercodpee", $peer_aluno->peercodpee);
            $this->tag->setDefault("alunocod_matricula", $peer_aluno->alunocod_matricula);
            $this->tag->setDefault("datexecpeer", $peer_aluno->datexecpeer);
            
        }
    }

    /**
     * Creates a new peer_aluno
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'index'
            ));

            return;
        }

        $peer_aluno = new PeerAluno();
        $peer_aluno->peercodpee = $this->request->getPost("peercodpee");
        $peer_aluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peer_aluno->datexecpeer = $this->request->getPost("datexecpeer");
        

        if (!$peer_aluno->save()) {
            foreach ($peer_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("peer_aluno was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "peer_aluno",
            'action' => 'index'
        ));
    }

    /**
     * Saves a peer_aluno edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'index'
            ));

            return;
        }

        $peercodpee = $this->request->getPost("peercodpee");
        $peer_aluno = PeerAluno::findFirstBypeercodpee($peercodpee);

        if (!$peer_aluno) {
            $this->flash->error("peer_aluno does not exist " . $peercodpee);

            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'index'
            ));

            return;
        }

        $peer_aluno->peercodpee = $this->request->getPost("peercodpee");
        $peer_aluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peer_aluno->datexecpeer = $this->request->getPost("datexecpeer");
        

        if (!$peer_aluno->save()) {

            foreach ($peer_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'edit',
                'params' => array($peer_aluno->peercodpee)
            ));

            return;
        }

        $this->flash->success("peer_aluno was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "peer_aluno",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a peer_aluno
     *
     * @param string $peercodpee
     */
    public function deleteAction($peercodpee)
    {
        $peer_aluno = PeerAluno::findFirstBypeercodpee($peercodpee);
        if (!$peer_aluno) {
            $this->flash->error("peer_aluno was not found");

            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'index'
            ));

            return;
        }

        if (!$peer_aluno->delete()) {

            foreach ($peer_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peer_aluno",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("peer_aluno was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "peer_aluno",
            'action' => "index"
        ));
    }

}
