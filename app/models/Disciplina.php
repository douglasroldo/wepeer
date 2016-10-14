<?php

class Disciplina extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $cod_dis;

    /**
     *
     * @var string
     */
    public $desdis;

    /**
     *
     * @var integer
     */
    public $turmacodtur;

    /**
     *
     * @var integer
     */
    public $carhordis;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('cod_dis', 'Matriz', 'disciplinacod_dis', array('alias' => 'Matriz'));
        $this->belongsTo('turmacodtur', 'Turma', 'codtur', array('alias' => 'Turma'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'disciplina';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Disciplina[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Disciplina
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
