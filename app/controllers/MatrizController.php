<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class MatrizController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for matriz
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Matriz', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "disciplinacod_dis";

        $matriz = Matriz::find($parameters);
        if (count($matriz) == 0) {
            $this->flash->notice("A busca não encontrou nenhuma matriz");

            $this->dispatcher->forward(array(
                "controller" => "matriz",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $matriz,
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
     * Edits a matriz
     *
     * @param string $disciplinacod_dis
     */
    public function editAction($disciplinacod_dis)
    {
        if (!$this->request->isPost()) {

            $matriz = Matriz::findFirstBydisciplinacod_dis($disciplinacod_dis);
            if (!$matriz) {
                $this->flash->error("Matriz não foi encontrado");

                $this->dispatcher->forward(array(
                    'controller' => "matriz",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->disciplinacod_dis = $matriz->disciplinacod_dis;

            $this->tag->setDefault("disciplinacod_dis", $matriz->disciplinacod_dis);
            $this->tag->setDefault("cursocodcur", $matriz->cursocodcur);
            $this->tag->setDefault("fasmat", $matriz->fasmat);
            
        }
    }

    /**
     * Creates a new matriz
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'index'
            ));

            return;
        }

        $matriz = new Matriz();
        $matriz->disciplinacod_dis = $this->request->getPost("disciplinacod_dis");
        $matriz->cursocodcur = $this->request->getPost("cursocodcur");
        $matriz->fasmat = $this->request->getPost("fasmat");
        

        if (!$matriz->save()) {
            foreach ($matriz->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("Matriz foi criado com êxito");

        $this->dispatcher->forward(array(
            'controller' => "matriz",
            'action' => 'index'
        ));
    }

    /**
     * Saves a matriz edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'index'
            ));

            return;
        }

        $disciplinacod_dis = $this->request->getPost("disciplinacod_dis");
        $matriz = Matriz::findFirstBydisciplinacod_dis($disciplinacod_dis);

        if (!$matriz) {
            $this->flash->error("Matriz não existe " . $disciplinacod_dis);

            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'index'
            ));

            return;
        }

        $matriz->disciplinacod_dis = $this->request->getPost("disciplinacod_dis");
        $matriz->cursocodcur = $this->request->getPost("cursocodcur");
        $matriz->fasmat = $this->request->getPost("fasmat");
        

        if (!$matriz->save()) {

            foreach ($matriz->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'edit',
                'params' => array($matriz->disciplinacod_dis)
            ));

            return;
        }

        $this->flash->success("Matriz foi atualizada com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "matriz",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a matriz
     *
     * @param string $disciplinacod_dis
     */
    public function deleteAction($disciplinacod_dis)
    {
        $matriz = Matriz::findFirstBydisciplinacod_dis($disciplinacod_dis);
        if (!$matriz) {
            $this->flash->error("Matriz não foi encontrada");

            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'index'
            ));

            return;
        }

        if (!$matriz->delete()) {

            foreach ($matriz->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "matriz",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("Matriz foi deletada com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "matriz",
            'action' => "index"
        ));
    }

}
