<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;

class PessoaForm extends Form {

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array()) {

        // Turma
        $turma = new Text('turmacodtur');
        $turma->setLabel('Turma');
        $turma->setFilters(array('striptags', 'string'));
        $turma->addValidators(array(
            new PresenceOf(array(
                'message' => 'Turma é obrigatório!'
                    ))
        ));
        $this->add($turma);

        // Nome
        $nome = new Text('despee');
        $nome->setLabel('Nome');
        $nome->addValidators(array(
            new PresenceOf(array(
                'message' => 'Nome é obrigatório!'
                    ))
        ));
        $this->add($nome);
        // Data Inicial
        $datainicial = new Date('dasexepee');
        $datainicial->setLabel('Data inicial');
        $datainicial->addValidators(array(
            new PresenceOf(array(
                'message' => 'Data inicial é obrigatória!'
                    ))
        ));
        $this->add($datainicial);
        //Data Final
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
