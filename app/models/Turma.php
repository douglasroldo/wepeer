<?php

class Turma extends \Phalcon\Mvc\Model
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
    public $profesorpessoacodigo;

    /**
     *
     * @var integer
     */
    public $codtur;

    /**
     *
     * @var string
     */
    public $destur;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codtur', 'Disciplina', 'turmacodtur', array('alias' => 'Disciplina'));
        $this->hasMany('codtur', 'Peer', 'turmacodtur', array('alias' => 'Peer'));
        $this->hasMany('codtur', 'TurmaAluno', 'turmacodtur', array('alias' => 'TurmaAluno'));
        $this->belongsTo('profesorpessoacodigo', 'Professor', 'codprofessor', array('alias' => 'Professor'));
        $this->belongsTo('alunocod_matricula', 'Aluno', 'codmat', array('alias' => 'Aluno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'turma';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Turma[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Turma
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
