<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class DisciplinaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for disciplina
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Disciplina', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "cod_dis";

        $disciplina = Disciplina::find($parameters);
        if (count($disciplina) == 0) {
            $this->flash->notice("The search did not find any disciplina");

            $this->dispatcher->forward(array(
                "controller" => "disciplina",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $disciplina,
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
     * Edits a disciplina
     *
     * @param string $cod_dis
     */
    public function editAction($cod_dis)
    {
        if (!$this->request->isPost()) {

            $disciplina = Disciplina::findFirstBycod_dis($cod_dis);
            if (!$disciplina) {
                $this->flash->error("disciplina was not found");

                $this->dispatcher->forward(array(
                    'controller' => "disciplina",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->cod_dis = $disciplina->cod_dis;

            $this->tag->setDefault("cod_dis", $disciplina->cod_dis);
            $this->tag->setDefault("desdis", $disciplina->desdis);
            $this->tag->setDefault("turmacodtur", $disciplina->turmacodtur);
            $this->tag->setDefault("carhordis", $disciplina->carhordis);
            
        }
    }

    /**
     * Creates a new disciplina
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'index'
            ));

            return;
        }

        $disciplina = new Disciplina();
        $disciplina->desdis = $this->request->getPost("desdis");
        $disciplina->turmacodtur = $this->request->getPost("turmacodtur");
        $disciplina->carhordis = $this->request->getPost("carhordis");
        

        if (!$disciplina->save()) {
            foreach ($disciplina->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("disciplina was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "disciplina",
            'action' => 'index'
        ));
    }

    /**
     * Saves a disciplina edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'index'
            ));

            return;
        }

        $cod_dis = $this->request->getPost("cod_dis");
        $disciplina = Disciplina::findFirstBycod_dis($cod_dis);

        if (!$disciplina) {
            $this->flash->error("disciplina does not exist " . $cod_dis);

            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'index'
            ));

            return;
        }

        $disciplina->desdis = $this->request->getPost("desdis");
        $disciplina->turmacodtur = $this->request->getPost("turmacodtur");
        $disciplina->carhordis = $this->request->getPost("carhordis");
        

        if (!$disciplina->save()) {

            foreach ($disciplina->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'edit',
                'params' => array($disciplina->cod_dis)
            ));

            return;
        }

        $this->flash->success("disciplina was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "disciplina",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a disciplina
     *
     * @param string $cod_dis
     */
    public function deleteAction($cod_dis)
    {
        $disciplina = Disciplina::findFirstBycod_dis($cod_dis);
        if (!$disciplina) {
            $this->flash->error("disciplina was not found");

            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'index'
            ));

            return;
        }

        if (!$disciplina->delete()) {

            foreach ($disciplina->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "disciplina",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("disciplina was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "disciplina",
            'action' => "index"
        ));
    }

}
