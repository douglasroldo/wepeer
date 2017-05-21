<?php

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;

class RegisterForm extends Form
{

    public function initialize($entity = null, $options = null)
    {
        // Name
        $name = new Text('name');
        $name->setLabel('Seu nome completo');
        $name->setFilters(array('striptags', 'string'));
        $name->addValidators(array(
            new PresenceOf(array(
                'message' => 'Name é necessário'
            ))
        ));
        $this->add($name);

       
        // Email
        $data_nas = new Text('data_nas');
        $data_nas->setLabel('Data de Nascimento');
        $data_nas->setFilters('data_nas');
        $data_nas->addValidators(array(
            new PresenceOf(array(
                'message' => 'Data Nascimento é necessário'
            )),
            new Email(array(
                'message' => 'Data Nascimento não é válido'
            ))
        ));
        $this->add($data_nas);
        
        $cpf = new Text('cpf');
        $cpf->setLabel('CPF');
        $cpf->setFilters('$cpf');
        $cpf->addValidators(array(
            new PresenceOf(array(
                'message' => 'CPF é necessario'
            )),
            new Email(array(
                'message' => 'CPF não é válido'
            ))
        ));
        
        $this->add($cpf);
        // Email
        $email = new Text('email');
        $email->setLabel('E-Mail');
        $email->setFilters('email');
        $email->addValidators(array(
            new PresenceOf(array(
                'message' => 'E-mail é necessário'
            )),
            new Email(array(
                'message' => 'E-mail não é válido'
            ))
        ));
        $this->add($email);

        // Password
        $password = new Password('password');
        $password->setLabel('Senha');
        $password->addValidators(array(
            new PresenceOf(array(
                'message' => 'Senha é necessário'
            ))
        ));
        $this->add($password);

        // Confirm Password
        $repeatPassword = new Password('repeatPassword');
        $repeatPassword->setLabel('Confirmação da senha');
        $repeatPassword->addValidators(array(
            new PresenceOf(array(
                'message' => 'A confirmação da sennha é obrigatoria'
            ))
        ));
        $this->add($repeatPassword);
    }
}