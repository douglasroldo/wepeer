<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class PeerForm extends Form {

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array()) {

        // Name
        $turma = new Text('turmacodtur');
        $turma->setLabel('Turma');
        $turma->setFilters(array('striptags', 'string'));
        $turma->addValidators(array(
            new PresenceOf(array(
                'message' => 'Turma é obrigatório!'
                    ))
        ));
        $this->add($turma);

        // Email
        $nome = new Text('despee');
        $nome->setLabel('Nome');
        $nome->addValidators(array(
            new PresenceOf(array(
                'message' => 'Nome é obrigatório!'
                    ))
        ));
        $this->add($nome);

        $datainicial = new Date('dasexepee');
        $datainicial->setLabel('Data inicial');
        $datainicial->addValidators(array(
            new PresenceOf(array(
                'message' => 'Data inicial é obrigatória!'
                    ))
        ));
        $this->add($datainicial);
        
        $datafinal = new Date('dasfimpee');
        $datafinal->setLabel('Data final');
        $datafinal->addValidators(array(
            new PresenceOf(array(
                'message' => 'Data final é obrigatória!'
                    ))
        ));
        $this->add($datafinal);
    }

}
