<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeerrespostasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for peerrespostas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peerrespostas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "alunocod_matricula";

        $peerrespostas = Peerrespostas::find($parameters);
        if (count($peerrespostas) == 0) {
            $this->flash->notice("The search did not find any peerrespostas");

            $this->dispatcher->forward(array(
                "controller" => "peerrespostas",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peerrespostas,
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
     * Edits a peerresposta
     *
     * @param string $alunocod_matricula
     */
    public function editAction($alunocod_matricula)
    {
        if (!$this->request->isPost()) {

            $peerresposta = Peerrespostas::findFirstByalunocod_matricula($alunocod_matricula);
            if (!$peerresposta) {
                $this->flash->error("peerresposta was not found");

                $this->dispatcher->forward(array(
                    'controller' => "peerrespostas",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->alunocod_matricula = $peerresposta->alunocod_matricula;

            $this->tag->setDefault("alunocod_matricula", $peerresposta->alunocod_matricula);
            $this->tag->setDefault("opcaocodopc", $peerresposta->opcaocodopc);
            
        }
    }

    /**
     * Creates a new peerresposta
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'index'
            ));

            return;
        }

        $peerresposta = new Peerrespostas();
        $peerresposta->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peerresposta->opcaocodopc = $this->request->getPost("opcaocodopc");
        

        if (!$peerresposta->save()) {
            foreach ($peerresposta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("peerresposta was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerrespostas",
            'action' => 'index'
        ));
    }

    /**
     * Saves a peerresposta edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'index'
            ));

            return;
        }

        $alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peerresposta = Peerrespostas::findFirstByalunocod_matricula($alunocod_matricula);

        if (!$peerresposta) {
            $this->flash->error("peerresposta does not exist " . $alunocod_matricula);

            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'index'
            ));

            return;
        }

        $peerresposta->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $peerresposta->opcaocodopc = $this->request->getPost("opcaocodopc");
        

        if (!$peerresposta->save()) {

            foreach ($peerresposta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'edit',
                'params' => array($peerresposta->alunocod_matricula)
            ));

            return;
        }

        $this->flash->success("peerresposta was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerrespostas",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a peerresposta
     *
     * @param string $alunocod_matricula
     */
    public function deleteAction($alunocod_matricula)
    {
        $peerresposta = Peerrespostas::findFirstByalunocod_matricula($alunocod_matricula);
        if (!$peerresposta) {
            $this->flash->error("peerresposta was not found");

            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'index'
            ));

            return;
        }

        if (!$peerresposta->delete()) {

            foreach ($peerresposta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerrespostas",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("peerresposta was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerrespostas",
            'action' => "index"
        ));
    }

}
