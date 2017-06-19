<?php

class Alunos_Relatorios extends \Phalcon\Mvc\Model
{

    
    public function initialize()
    {
        $this->setSchema("public");
    
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        ;
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeerAluno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeerAluno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
