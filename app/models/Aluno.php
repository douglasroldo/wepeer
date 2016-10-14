<?php

class Aluno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $codmat;

    /**
     *
     * @var string
     */
    public $desalu;

    /**
     *
     * @var string
     */
    public $dascadalu;

    /**
     *
     * @var string
     */
    public $sitalu;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codmat', 'PeerAluno', 'alunocod_matricula', array('alias' => 'PeerAluno'));
        $this->hasMany('codmat', 'Peerrespostas', 'alunocod_matricula', array('alias' => 'Peerrespostas'));
        $this->hasMany('codmat', 'Pessoa', 'alunocod_matricula', array('alias' => 'Pessoa'));
        $this->hasMany('codmat', 'Turma', 'alunocod_matricula', array('alias' => 'Turma'));
        $this->hasMany('codmat', 'TurmaAluno', 'alunocod_matricula', array('alias' => 'TurmaAluno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'aluno';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aluno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Aluno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
