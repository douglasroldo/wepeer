<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TurmaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for turma
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Turma', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "alunocod_matricula";

        $turma = Turma::find($parameters);
        if (count($turma) == 0) {
            $this->flash->notice("The search did not find any turma");

            $this->dispatcher->forward(array(
                "controller" => "turma",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $turma,
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
     * Edits a turma
     *
     * @param string $alunocod_matricula
     */
    public function editAction($alunocod_matricula)
    {
        if (!$this->request->isPost()) {

            $turma = Turma::findFirstByalunocod_matricula($alunocod_matricula);
            if (!$turma) {
                $this->flash->error("turma was not found");

                $this->dispatcher->forward(array(
                    'controller' => "turma",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->alunocod_matricula = $turma->alunocod_matricula;

            $this->tag->setDefault("alunocod_matricula", $turma->alunocod_matricula);
            $this->tag->setDefault("profesorpessoacodigo", $turma->profesorpessoacodigo);
            $this->tag->setDefault("codtur", $turma->codtur);
            $this->tag->setDefault("destur", $turma->destur);
            
        }
    }

    /**
     * Creates a new turma
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'index'
            ));

            return;
        }

        $turma = new Turma();
        $turma->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $turma->profesorpessoacodigo = $this->request->getPost("profesorpessoacodigo");
        $turma->destur = $this->request->getPost("destur");
        

        if (!$turma->save()) {
            foreach ($turma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("turma was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma",
            'action' => 'index'
        ));
    }

    /**
     * Saves a turma edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'index'
            ));

            return;
        }

        $alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $turma = Turma::findFirstByalunocod_matricula($alunocod_matricula);

        if (!$turma) {
            $this->flash->error("turma does not exist " . $alunocod_matricula);

            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'index'
            ));

            return;
        }

        $turma->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $turma->profesorpessoacodigo = $this->request->getPost("profesorpessoacodigo");
        $turma->destur = $this->request->getPost("destur");
        

        if (!$turma->save()) {

            foreach ($turma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'edit',
                'params' => array($turma->alunocod_matricula)
            ));

            return;
        }

        $this->flash->success("turma was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a turma
     *
     * @param string $alunocod_matricula
     */
    public function deleteAction($alunocod_matricula)
    {
        $turma = Turma::findFirstByalunocod_matricula($alunocod_matricula);
        if (!$turma) {
            $this->flash->error("turma was not found");

            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'index'
            ));

            return;
        }

        if (!$turma->delete()) {

            foreach ($turma->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("turma was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma",
            'action' => "index"
        ));
    }

}
