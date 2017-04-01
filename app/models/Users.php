<?php

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Validator\Email as EmailValidator;
use Phalcon\Mvc\Model\Validator\Uniqueness as UniquenessValidator;

class Users extends Model
{
    public function validation()
    {
        $this->validate(new EmailValidator(array(
            'field' => 'email'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'email',
            'message' => 'Desculpe, O email foi registrado por outro usuário'
        )));
        $this->validate(new UniquenessValidator(array(
            'field' => 'username',
            'message' => 'Desculpe-me, este nome de usuário já está sendo utilizado'
        )));
        if ($this->validationHasFailed() == true) {
            return false;
        }
    }
}
