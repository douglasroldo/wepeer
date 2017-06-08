<?php

use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Date;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;
                
class PerguntaForm extends Form {

    /**
     * Initialize the products form
     */
    public function initialize($entity = null, $options = array()) {

        // pergunta
        $pergunta = new Text('desper');
        $pergunta->setLabel('`Pergunta');
        $pergunta->setFilters(array('striptags', 'string'));
        $pergunta->addValidators(array(
            new PresenceOf(array(
                'message' => 'Pergunta é obrigatório!'
                    ))
        ));
        $this->add($pergunta);
        
        
        
        
        
    }

}
