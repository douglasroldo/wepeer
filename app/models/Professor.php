<?php

class Professor extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $codprofessor;

    /**
     *
     * @var string
     */
    public $despro;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codprofessor', 'Turma', 'profesorpessoacodigo', array('alias' => 'Turma'));
        $this->belongsTo('codprofessor', 'Pessoa', 'codpes', array('alias' => 'Pessoa'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'professor';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Professor[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Professor
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
