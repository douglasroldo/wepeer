<?php

class TurmaAluno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $turmacodtur;

    /**
     *
     * @var integer
     */
    public $alunocod_matricula;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('turmacodtur', 'Turma', 'codtur', array('alias' => 'Turma'));
        $this->belongsTo('alunocod_matricula', 'Aluno', 'codmat', array('alias' => 'Aluno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'turma_aluno';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return TurmaAluno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return TurmaAluno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
