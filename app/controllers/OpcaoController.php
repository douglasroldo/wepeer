<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class OpcaoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for opcao
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Opcao', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "perguntacodper";

        $opcao = Opcao::find($parameters);
        if (count($opcao) == 0) {
            $this->flash->notice("The search did not find any opcao");

            $this->dispatcher->forward([
                "controller" => "opcao",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $opcao,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a opcao
     *
     * @param string $perguntacodper
     */
    public function editAction($perguntacodper)
    {
        if (!$this->request->isPost()) {

            $opcao = Opcao::findFirstByperguntacodper($perguntacodper);
            if (!$opcao) {
                $this->flash->error("opcao was not found");

                $this->dispatcher->forward([
                    'controller' => "opcao",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->perguntacodper = $opcao->perguntacodper;

            $this->tag->setDefault("perguntacodper", $opcao->perguntacodper);
            $this->tag->setDefault("codopc", $opcao->codopc);
            $this->tag->setDefault("desopc", $opcao->desopc);
            
        }
    }

    /**
     * Creates a new opcao
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'index'
            ]);

            return;
        }

        $opcao = new Opcao();
        $opcao->perguntacodper = $this->request->getPost("perguntacodper");
        $opcao->desopc = $this->request->getPost("desopc");
        

        if (!$opcao->save()) {
            foreach ($opcao->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("opcao was created successfully");

        $this->dispatcher->forward([
            'controller' => "opcao",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a opcao edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'index'
            ]);

            return;
        }

        $perguntacodper = $this->request->getPost("perguntacodper");
        $opcao = Opcao::findFirstByperguntacodper($perguntacodper);

        if (!$opcao) {
            $this->flash->error("opcao does not exist " . $perguntacodper);

            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'index'
            ]);

            return;
        }

        $opcao->perguntacodper = $this->request->getPost("perguntacodper");
        $opcao->desopc = $this->request->getPost("desopc");
        

        if (!$opcao->save()) {

            foreach ($opcao->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'edit',
                'params' => [$opcao->perguntacodper]
            ]);

            return;
        }

        $this->flash->success("opcao was updated successfully");

        $this->dispatcher->forward([
            'controller' => "opcao",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a opcao
     *
     * @param string $perguntacodper
     */
    public function deleteAction($perguntacodper)
    {
        $opcao = Opcao::findFirstByperguntacodper($perguntacodper);
        if (!$opcao) {
            $this->flash->error("opcao was not found");

            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'index'
            ]);

            return;
        }

        if (!$opcao->delete()) {

            foreach ($opcao->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "opcao",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("opcao was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "opcao",
            'action' => "index"
        ]);
    }

}
