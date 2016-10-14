<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class AlunoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for aluno
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Aluno', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "codmat";

        $aluno = Aluno::find($parameters);
        if (count($aluno) == 0) {
            $this->flash->notice("A pesquisa não encontrou nenhum Aluno");

            $this->dispatcher->forward(array(
                "controller" => "aluno",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $aluno,
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
     * Edits a aluno
     *
     * @param string $codmat
     */
    public function editAction($codmat)
    {
        if (!$this->request->isPost()) {

            $aluno = Aluno::findFirstBycodmat($codmat);
            if (!$aluno) {
                $this->flash->error("Aluno não foi encontrado");

                $this->dispatcher->forward(array(
                    'controller' => "aluno",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->codmat = $aluno->codmat;

            $this->tag->setDefault("codmat", $aluno->codmat);
            $this->tag->setDefault("desalu", $aluno->desalu);
            $this->tag->setDefault("dascadalu", $aluno->dascadalu);
            $this->tag->setDefault("sitalu", $aluno->sitalu);
            
        }
    }

    /**
     * Creates a new aluno
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'index'
            ));

            return;
        }

        $aluno = new Aluno();
        $aluno->desalu = $this->request->getPost("desalu");
        $aluno->dascadalu = $this->request->getPost("dascadalu");
        $aluno->sitalu = $this->request->getPost("sitalu");
        

        if (!$aluno->save()) {
            foreach ($aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("Aluno foi criado com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "aluno",
            'action' => 'index'
        ));
    }

    /**
     * Saves a aluno edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'index'
            ));

            return;
        }

        $codmat = $this->request->getPost("codmat");
        $aluno = Aluno::findFirstBycodmat($codmat);

        if (!$aluno) {
            $this->flash->error("O aluno não existe" . $codmat);

            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'index'
            ));

            return;
        }

        $aluno->desalu = $this->request->getPost("desalu");
        $aluno->dascadalu = $this->request->getPost("dascadalu");
        $aluno->sitalu = $this->request->getPost("sitalu");
        

        if (!$aluno->save()) {

            foreach ($aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'edit',
                'params' => array($aluno->codmat)
            ));

            return;
        }

        $this->flash->success("Aluno foi atualizado com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "aluno",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a aluno
     *
     * @param string $codmat
     */
    public function deleteAction($codmat)
    {
        $aluno = Aluno::findFirstBycodmat($codmat);
        if (!$aluno) {
            $this->flash->error("Aluno não foi encontrado");

            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'index'
            ));

            return;
        }

        if (!$aluno->delete()) {

            foreach ($aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "aluno",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("Aluno foi excluído com sucesso");

        $this->dispatcher->forward(array(
            'controller' => "aluno",
            'action' => "index"
        ));
    }

}
