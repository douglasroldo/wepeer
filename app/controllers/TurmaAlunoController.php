<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class TurmaAlunoController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for turma_aluno
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'TurmaAluno', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "turmacodtur";

        $turma_aluno = TurmaAluno::find($parameters);
        if (count($turma_aluno) == 0) {
            $this->flash->notice("The search did not find any turma_aluno");

            $this->dispatcher->forward(array(
                "controller" => "turma_aluno",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $turma_aluno,
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
     * Edits a turma_aluno
     *
     * @param string $turmacodtur
     */
    public function editAction($turmacodtur)
    {
        if (!$this->request->isPost()) {

            $turma_aluno = TurmaAluno::findFirstByturmacodtur($turmacodtur);
            if (!$turma_aluno) {
                $this->flash->error("turma_aluno was not found");

                $this->dispatcher->forward(array(
                    'controller' => "turma_aluno",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->turmacodtur = $turma_aluno->turmacodtur;

            $this->tag->setDefault("turmacodtur", $turma_aluno->turmacodtur);
            $this->tag->setDefault("alunocod_matricula", $turma_aluno->alunocod_matricula);
            
        }
    }

    /**
     * Creates a new turma_aluno
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'index'
            ));

            return;
        }

        $turma_aluno = new TurmaAluno();
        $turma_aluno->turmacodtur = $this->request->getPost("turmacodtur");
        $turma_aluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        

        if (!$turma_aluno->save()) {
            foreach ($turma_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'new'
            ));

            return;
        }

        $this->flash->success("turma_aluno was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma_aluno",
            'action' => 'index'
        ));
    }

    /**
     * Saves a turma_aluno edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'index'
            ));

            return;
        }

        $turmacodtur = $this->request->getPost("turmacodtur");
        $turma_aluno = TurmaAluno::findFirstByturmacodtur($turmacodtur);

        if (!$turma_aluno) {
            $this->flash->error("turma_aluno does not exist " . $turmacodtur);

            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'index'
            ));

            return;
        }

        $turma_aluno->turmacodtur = $this->request->getPost("turmacodtur");
        $turma_aluno->alunocod_matricula = $this->request->getPost("alunocod_matricula");
        

        if (!$turma_aluno->save()) {

            foreach ($turma_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'edit',
                'params' => array($turma_aluno->turmacodtur)
            ));

            return;
        }

        $this->flash->success("turma_aluno was updated successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma_aluno",
            'action' => 'index'
        ));
    }

    /**
     * Deletes a turma_aluno
     *
     * @param string $turmacodtur
     */
    public function deleteAction($turmacodtur)
    {
        $turma_aluno = TurmaAluno::findFirstByturmacodtur($turmacodtur);
        if (!$turma_aluno) {
            $this->flash->error("turma_aluno was not found");

            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'index'
            ));

            return;
        }

        if (!$turma_aluno->delete()) {

            foreach ($turma_aluno->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "turma_aluno",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("turma_aluno was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "turma_aluno",
            'action' => "index"
        ));
    }

}
