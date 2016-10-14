<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class ProfessorController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for professor
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Professor', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "codprofessor";

        $professor = Professor::find($parameters);
        if (count($professor) == 0) {
            $this->flash->notice("The search did not find any professor");

            $this->dispatcher->forward(array(
                "controller" => "professor",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $professor,
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
     * Edits a professor
     *
     * @param string $codprofessor
     */
    public function editAction($codprofessor)
    {
        if (!$this->request->isPost()) {

            $professor = Professor::findFirstBycodprofessor($codprofessor);
            if (!$professor) {
                $this->flash->error("professor was not found");

                $this->dispatcher->forward(array(
                    'controller' => "professor",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->codprofessor = $professor->codprofessor;

            $this->tag->setDefault("codprofessor", $professor->codprofessor);
            $this->tag->setDefault("despro", $professor->despro);
            
        }
    }

    /**
     * Creates a new professor
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'index'
            ));

            return;
        }

        $professor = new Professor();
        $professor->codprofessor = $this->request->getPost("codprofessor");
        $professor->despro = $this->request->getPost("despro");
        

        if (!$professor->save()) {
            foreach ($professor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("professor was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "professor",
            'action' => 'index'
        ));
    }

    /**
     * Saves a professor edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'index'
            ));

            return;
        }

        $codprofessor = $this->request->getPost("codprofessor");
        $professor = Professor::findFirstBycodprofessor($codprofessor);

        if (!$professor) {
            $this->flash->error("professor does not exist " . $codprofessor);

            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'index'
            ));

            return;
        }

        $professor->codprofessor = $this->request->getPost("codprofessor");
        $professor->despro = $this->request->getPost("despro");
        

        if (!$professor->save()) {

            foreach ($professor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'edit',
                'params' => array($professor->codprofessor)
            ));

            return;
        }

        $this->flash->success("professor was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "professor",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a professor
     *
     * @param string $codprofessor
     */
    public function deleteAction($codprofessor)
    {
        $professor = Professor::findFirstBycodprofessor($codprofessor);
        if (!$professor) {
            $this->flash->error("professor was not found");

            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'index'
            ));

            return;
        }

        if (!$professor->delete()) {

            foreach ($professor->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "professor",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("professor was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "professor",
            'action' => "index"
        ));
    }

}
