<?php

class Peerrespostas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $alunocod_matricula;

    /**
     *
     * @var integer
     */
    public $opcaocodopc;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('alunocod_matricula', 'Aluno', 'codmat', array('alias' => 'Aluno'));
        $this->belongsTo('opcaocodopc', 'Opcao', 'codopc', array('alias' => 'Opcao'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'peerrespostas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peerrespostas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peerrespostas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
