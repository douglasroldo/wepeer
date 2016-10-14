<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeerperguntasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for peerperguntas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peerperguntas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "perguntacodper";

        $peerperguntas = Peerperguntas::find($parameters);
        if (count($peerperguntas) == 0) {
            $this->flash->notice("The search did not find any peerperguntas");

            $this->dispatcher->forward(array(
                "controller" => "peerperguntas",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peerperguntas,
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
     * Edits a peerpergunta
     *
     * @param string $perguntacodper
     */
    public function editAction($perguntacodper)
    {
        if (!$this->request->isPost()) {

            $peerpergunta = Peerperguntas::findFirstByperguntacodper($perguntacodper);
            if (!$peerpergunta) {
                $this->flash->error("peerpergunta was not found");

                $this->dispatcher->forward(array(
                    'controller' => "peerperguntas",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->perguntacodper = $peerpergunta->perguntacodper;

            $this->tag->setDefault("perguntacodper", $peerpergunta->perguntacodper);
            $this->tag->setDefault("peercodpee", $peerpergunta->peercodpee);
            $this->tag->setDefault("ordpee", $peerpergunta->ordpee);
            $this->tag->setDefault("obrirespeer", $peerpergunta->obrirespeer);
            
        }
    }

    /**
     * Creates a new peerpergunta
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));

            return;
        }

        $peerpergunta = new Peerperguntas();
        $peerpergunta->perguntacodper = $this->request->getPost("perguntacodper");
        $peerpergunta->peercodpee = $this->request->getPost("peercodpee");
        $peerpergunta->ordpee = $this->request->getPost("ordpee");
        $peerpergunta->obrirespeer = $this->request->getPost("obrirespeer");
        

        if (!$peerpergunta->save()) {
            foreach ($peerpergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("peerpergunta was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerperguntas",
            'action' => 'index'
        ));
    }

    /**
     * Saves a peerpergunta edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));

            return;
        }

        $perguntacodper = $this->request->getPost("perguntacodper");
        $peerpergunta = Peerperguntas::findFirstByperguntacodper($perguntacodper);

        if (!$peerpergunta) {
            $this->flash->error("peerpergunta does not exist " . $perguntacodper);

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));

            return;
        }

        $peerpergunta->perguntacodper = $this->request->getPost("perguntacodper");
        $peerpergunta->peercodpee = $this->request->getPost("peercodpee");
        $peerpergunta->ordpee = $this->request->getPost("ordpee");
        $peerpergunta->obrirespeer = $this->request->getPost("obrirespeer");
        

        if (!$peerpergunta->save()) {

            foreach ($peerpergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'edit',
                'params' => array($peerpergunta->perguntacodper)
            ));

            return;
        }

        $this->flash->success("peerpergunta was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerperguntas",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a peerpergunta
     *
     * @param string $perguntacodper
     */
    public function deleteAction($perguntacodper)
    {
        $peerpergunta = Peerperguntas::findFirstByperguntacodper($perguntacodper);
        if (!$peerpergunta) {
            $this->flash->error("peerpergunta was not found");

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));

            return;
        }

        if (!$peerpergunta->delete()) {

            foreach ($peerpergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("peerpergunta was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerperguntas",
            'action' => "index"
        ));
    }

}
