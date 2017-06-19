<?php
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;
class PeerRelatoriosController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle(' | Peer Relatórios');
        parent::initialize();
    }

    
    public function indexAction() {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'Peer', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters ["order"] = "turmacodtur";
        $peer = Peer::find($parameters);
        if (count($peer) == 0) {
            $this->flash->notice("A busca não encontrou nenhum peer");

            $this->dispatcher->forward(array(
                "controller" => "peer",
                "action" => "index"
            ));

            return;
        }

        $paginator = new Paginator(array(
            'data' => $peer,
            'limit' => 10,
            'page' => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }
    
    public function emitirRelatorioAction(){
       
    }

}
