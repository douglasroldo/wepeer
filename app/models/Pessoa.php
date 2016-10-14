<?php

class Pessoa extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $codpes;

    /**
     *
     * @var string
     */
    public $nompes;

    /**
     *
     * @var string
     */
    public $fotpes;

    /**
     *
     * @var string
     */
    public $cpfpes;

    /**
     *
     * @var integer
     */
    public $alunocod_matricula;

    /**
     *
     * @var string
     */
    public $dasnascpes;

    /**
     *
     * @var string
     */
    public $emapes;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codpes', 'Professor', 'codprofessor', array('alias' => 'Professor'));
        $this->belongsTo('alunocod_matricula', 'Aluno', 'codmat', array('alias' => 'Aluno'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pessoa';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pessoa[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pessoa
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
