<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CursoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for curso
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Curso', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "codcur";

        $curso = Curso::find($parameters);
        if (count($curso) == 0) {
            $this->flash->notice("The search did not find any curso");

            $this->dispatcher->forward(array(
                "controller" => "curso",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $curso,
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
     * Edits a curso
     *
     * @param string $codcur
     */
    public function editAction($codcur)
    {
        if (!$this->request->isPost()) {

            $curso = Curso::findFirstBycodcur($codcur);
            if (!$curso) {
                $this->flash->error("curso was not found");

                $this->dispatcher->forward(array(
                    'controller' => "curso",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->codcur = $curso->codcur;

            $this->tag->setDefault("codcur", $curso->codcur);
            $this->tag->setDefault("descur", $curso->descur);
            
        }
    }

    /**
     * Creates a new curso
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'index'
            ));

            return;
        }

        $curso = new Curso();
        $curso->descur = $this->request->getPost("descur");
        

        if (!$curso->save()) {
            foreach ($curso->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("curso was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "curso",
            'action' => 'index'
        ));
    }

    /**
     * Saves a curso edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'index'
            ));

            return;
        }

        $codcur = $this->request->getPost("codcur");
        $curso = Curso::findFirstBycodcur($codcur);

        if (!$curso) {
            $this->flash->error("curso does not exist " . $codcur);

            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'index'
            ));

            return;
        }

        $curso->descur = $this->request->getPost("descur");
        

        if (!$curso->save()) {

            foreach ($curso->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'edit',
                'params' => array($curso->codcur)
            ));

            return;
        }

        $this->flash->success("curso was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "curso",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a curso
     *
     * @param string $codcur
     */
    public function deleteAction($codcur)
    {
        $curso = Curso::findFirstBycodcur($codcur);
        if (!$curso) {
            $this->flash->error("curso was not found");

            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'index'
            ));

            return;
        }

        if (!$curso->delete()) {

            foreach ($curso->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "curso",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("curso was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "curso",
            'action' => "index"
        ));
    }

}
