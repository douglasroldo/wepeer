<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PessoaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for pessoa
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Pessoa', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "codpes";

        $pessoa = Pessoa::find($parameters);
        if (count($pessoa) == 0) {
            $this->flash->notice("The search did not find any pessoa");

            $this->dispatcher->forward(array(
                "controller" => "pessoa",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $pessoa,
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
     * Edits a pessoa
     *
     * @param string $codpes
     */
    public function editAction($codpes)
    {
        if (!$this->request->isPost()) {

            $pessoa = Pessoa::findFirstBycodpes($codpes);
            if (!$pessoa) {
                $this->flash->error("pessoa was not found");

                $this->dispatcher->forward(array(
                    'controller' => "pessoa",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->codpes = $pessoa->codpes;

            $this->tag->setDefault("codpes", $pessoa->codpes);
            $this->tag->setDefault("nompes", $pessoa->nompes);
            $this->tag->setDefault("fotpes", $pessoa->fotpes);
            $this->tag->setDefault("cpfpes", $pessoa->cpfpes);
            $this->tag->setDefault("alunocod_matricula", $pessoa->alunocod_matricula);
            $this->tag->setDefault("dasnascpes", $pessoa->dasnascpes);
            $this->tag->setDefault("emapes", $pessoa->emapes);
            
        }
    }

    /**
     * Creates a new pessoa
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'index'
            ));

            return;
        }

        $pessoa = new Pessoa();
        $pessoa->codpes = $this->request->getPost("codpes");
        $pessoa->nompes = $this->request->getPost("nompes");
        $pessoa->fotpes = $this->request->getPost("fotpes");
        $pessoa->cpfpes = $this->request->getPost("cpfpes");
        $pessoa->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $pessoa->dasnascpes = $this->request->getPost("dasnascpes");
        $pessoa->emapes = $this->request->getPost("emapes");
        

        if (!$pessoa->save()) {
            foreach ($pessoa->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("pessoa was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "pessoa",
            'action' => 'index'
        ));
    }

    /**
     * Saves a pessoa edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'index'
            ));

            return;
        }

        $codpes = $this->request->getPost("codpes");
        $pessoa = Pessoa::findFirstBycodpes($codpes);

        if (!$pessoa) {
            $this->flash->error("pessoa does not exist " . $codpes);

            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'index'
            ));

            return;
        }

        $pessoa->codpes = $this->request->getPost("codpes");
        $pessoa->nompes = $this->request->getPost("nompes");
        $pessoa->fotpes = $this->request->getPost("fotpes");
        $pessoa->cpfpes = $this->request->getPost("cpfpes");
        $pessoa->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        $pessoa->dasnascpes = $this->request->getPost("dasnascpes");
        $pessoa->emapes = $this->request->getPost("emapes");
        

        if (!$pessoa->save()) {

            foreach ($pessoa->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'edit',
                'params' => array($pessoa->codpes)
            ));

            return;
        }

        $this->flash->success("pessoa was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "pessoa",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a pessoa
     *
     * @param string $codpes
     */
    public function deleteAction($codpes)
    {
        $pessoa = Pessoa::findFirstBycodpes($codpes);
        if (!$pessoa) {
            $this->flash->error("pessoa was not found");

            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'index'
            ));

            return;
        }

        if (!$pessoa->delete()) {

            foreach ($pessoa->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pessoa",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("pessoa was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "pessoa",
            'action' => "index"
        ));
    }

}
