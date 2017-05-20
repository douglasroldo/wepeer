<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class PeerperguntasController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for peerperguntas
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peerperguntas', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "perguntacodper";

        $peerperguntas = Peerperguntas::find($parameters);
        if (count($peerperguntas) == 0) {
            $this->flash->notice("The search did not find any peerperguntas");

            $this->dispatcher->forward(array(
                "controller" => "peerperguntas",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peerperguntas,
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
     * Edits a peerpergunta
     *
     * @param string $perguntacodper
     */
    public function editAction($perguntacodper)
    {
        if (!$this->request->isPost()) {

            $peerpergunta = Peerperguntas::findFirstByperguntacodper($perguntacodper);
            if (!$peerpergunta) {
                $this->flash->error("peerpergunta was not found");

                $this->dispatcher->forward(array(
                    'controller' => "peerperguntas",
                    'action' => 'index'
                ));

                return;
            }

            $this->view->perguntacodper = $peerpergunta->perguntacodper;

            $this->tag->setDefault("perguntacodper", $peerpergunta->perguntacodper);
            $this->tag->setDefault("peercodpee", $peerpergunta->peercodpee);
            $this->tag->setDefault("ordpee", $peerpergunta->ordpee);
            $this->tag->setDefault("obrirespeer", $peerpergunta->obrirespeer);
            
        }
    }

    /**
     * Creates a new peerpergunta
     */
    public function createAction()
    {
        $id_pergunta = null;
        
        if (!$this->request->isPost()) {
            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));
            return;
        }
        
        if($this->request->isPost()){
            $pergunta = new Pergunta();
            
            $pergunta->desper = $this->request->getPost("peerper");
            $pergunta->rescer = 0; 
            
            if (!$pergunta->save()) {
                foreach ($pergunta->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }else{
               $id_pergunta = $pergunta->codper;
            }
            
               $opcao = new Opcao();
               $opcao->desopc = $this->request->getPost("resposta1");
               $opcao->perguntacodper = $id_pergunta;
               $opcao->save();
               if ($this->request->getPost("rescerta") == 1) {
                  $pergunta->rescer = $opcao->codopc; 
               }
               
               $opcao = new Opcao();
               $opcao->desopc = $this->request->getPost("resposta2");
               $opcao->perguntacodper = $id_pergunta;
               $opcao->save();
                if ($this->request->getPost("rescerta") == 2) {
                  $pergunta->rescer = $opcao->codopc; 
               }
               $opcao = new Opcao();
               $opcao->desopc = $this->request->getPost("resposta3");
               $opcao->perguntacodper = $id_pergunta;
               $opcao->save();
               if ($this->request->getPost("rescerta") == 3) {
                  $pergunta->rescer = $opcao->codopc; 
               }
               $opcao = new Opcao();
               $opcao->desopc = $this->request->getPost("resposta4");
               $opcao->perguntacodper = $id_pergunta;
               $opcao->save();
                if ($this->request->getPost("rescerta") == 4) {
                  $pergunta->rescer = $opcao->codopc; 
               }
               $pergunta->save();
               /**
               $respostas = array(
                   array(
                    'desopc' => $this->request->getPost("resposta1"),
                    'perguntacodper' => $id_pergunta   
                   ),
                   array(
                    'desopc' => $this->request->getPost("resposta2"),
                    'perguntacodper' => $id_pergunta   
                   ),
                   array(
                    'desopc' => $this->request->getPost("resposta3"),
                    'perguntacodper' => $id_pergunta   
                   ),
                   array(
                    'desopc' => $this->request->getPost("resposta4"),
                    'perguntacodper' => $id_pergunta   
                   )
               );
               $opcao->save($respostas, $opcao);
               **/
     
        }

        $this->flash->success("peerpergunta was created successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerperguntas",
            'action' => 'index'
        ));
    }



    /**
     * Deletes a peerpergunta
     *
     * @param string $perguntacodper
     */
    public function deleteAction($perguntacodper)
    {
        $peerpergunta = Peerperguntas::findFirstByperguntacodper($perguntacodper);
        if (!$peerpergunta) {
            $this->flash->error("peerpergunta was not found");

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'index'
            ));

            return;
        }

        if (!$peerpergunta->delete()) {

            foreach ($peerpergunta->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward(array(
                'controller' => "peerperguntas",
                'action' => 'search'
            ));

            return;
        }

        $this->flash->success("peerpergunta was deleted successfully");

        $this->dispatcher->forward(array(
            'controller' => "peerperguntas",
            'action' => "index"
        ));
    }

}
