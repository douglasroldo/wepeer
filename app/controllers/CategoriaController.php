<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class CategoriaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for categoria
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Categoria', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "codcat";

        $categoria = Categoria::find($parameters);
        if (count($categoria) == 0) {
            $this->flash->notice("The search did not find any categoria");

            $this->dispatcher->forward(array(
                "controller" => "categoria",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $categoria,
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
     * Edits a categoria
     *
     * @param string $codcat
     */
    public function editAction($codcat)
    {
        if (!$this->request->isPost()) {

            $categoria = Categoria::findFirstBycodcat($codcat);
            if (!$categoria) {
                $this->flash->error("categoria was not found");

                $this->dispatcher->forward(array(
                    'controller' => "categoria",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->codcat = $categoria->codcat;

            $this->tag->setDefault("codcat", $categoria->codcat);
            $this->tag->setDefault("descat", $categoria->descat);
            
        }
    }

    /**
     * Creates a new categoria
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'index'
            ));

            return;
        }

        $categoria = new Categoria();
        $categoria->descat = $this->request->getPost("descat");
        

        if (!$categoria->save()) {
            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("categoria was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "categoria",
            'action' => 'index'
        ));
    }

    /**
     * Saves a categoria edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'index'
            ));

            return;
        }

        $codcat = $this->request->getPost("codcat");
        $categoria = Categoria::findFirstBycodcat($codcat);

        if (!$categoria) {
            $this->flash->error("categoria does not exist " . $codcat);

            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'index'
            ));

            return;
        }

        $categoria->descat = $this->request->getPost("descat");
        

        if (!$categoria->save()) {

            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'edit',
                'params' => array($categoria->codcat)
            ));

            return;
        }

        $this->flash->success("categoria was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "categoria",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a categoria
     *
     * @param string $codcat
     */
    public function deleteAction($codcat)
    {
        $categoria = Categoria::findFirstBycodcat($codcat);
        if (!$categoria) {
            $this->flash->error("categoria was not found");

            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'index'
            ));

            return;
        }

        if (!$categoria->delete()) {

            foreach ($categoria->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "categoria",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("categoria was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "categoria",
            'action' => "index"
        ));
    }

}
