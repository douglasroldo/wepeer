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

        // Código
        $codigo = new Text('codpes');
        $codigo->setLabel('Código');
        $codigo->setFilters(array('striptags', 'integer'));
        $codigo->addValidators(array(
            new PresenceOf(array(
                'message' => 'Código é obrigatório!'
                    ))
        ));
        $this->add($codigo);

        // nome
        $nome = new Text('nompes');
        $nome->setLabel('Nome');
        $nome->addValidators(array(
            new PresenceOf(array(
                'message' => 'Nome é obrigatório!'
                    ))
        ));
        $this->add($nome);
    }

}
