<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PerguntaController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for pergunta
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Pergunta', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "categoriacodcat";

        $pergunta = Pergunta::find($parameters);
        if (count($pergunta) == 0) {
            $this->flash->notice("A busca não encontrou nenhuma pergunta");

            $this->dispatcher->forward(array(
                "controller" => "pergunta",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $pergunta,
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
     * Edits a pergunta
     *
     * @param string $categoriacodcat
     */
    public function editAction($categoriacodcat)
    {
        if (!$this->request->isPost()) {

            $pergunta = Pergunta::findFirstBycategoriacodcat($categoriacodcat);
            if (!$pergunta) {
                $this->flash->error("Pergunta não foi encontrado");

                $this->dispatcher->forward(array(
                    'controller' => "pergunta",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->categoriacodcat = $pergunta->categoriacodcat;

            $this->tag->setDefault("categoriacodcat", $pergunta->categoriacodcat);
            $this->tag->setDefault("codper", $pergunta->codper);
            $this->tag->setDefault("desper", $pergunta->desper);
            
        }
    }

    /**
     * Creates a new pergunta
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'index'
            ));

            return;
        }

        $pergunta = new Pergunta();
        $pergunta->categoriacodcat = $this->request->getPost("categoriacodcat");
        $pergunta->desper = $this->request->getPost("desper");
        

        if (!$pergunta->save()) {
            foreach ($pergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("Pergunta foi criado com êxito");

        $this->dispatcher->forward(array(
            'controller' => "pergunta",
            'action' => 'index'
        ));
    }

    /**
     * Saves a pergunta edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'index'
            ));

            return;
        }

        $categoriacodcat = $this->request->getPost("categoriacodcat");
        $pergunta = Pergunta::findFirstBycategoriacodcat($categoriacodcat);

        if (!$pergunta) {
            $this->flash->error("Pergunta não existe " . $categoriacodcat);

            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'index'
            ));

            return;
        }

        $pergunta->categoriacodcat = $this->request->getPost("categoriacodcat");
        $pergunta->desper = $this->request->getPost("desper");
        

        if (!$pergunta->save()) {

            foreach ($pergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'edit',
                'params' => array($pergunta->categoriacodcat)
            ));

            return;
        }

        $this->flash->success("Pergunta foi atualizada com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "pergunta",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a pergunta
     *
     * @param string $categoriacodcat
     */
    public function deleteAction($categoriacodcat)
    {
        $pergunta = Pergunta::findFirstBycategoriacodcat($categoriacodcat);
        if (!$pergunta) {
            $this->flash->error("Pergunta não foi encontrada");

            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'index'
            ));

            return;
        }

        if (!$pergunta->delete()) {

            foreach ($pergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "pergunta",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("Pergunta foi deletada com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "pergunta",
            'action' => "index"
        ));
    }

}
