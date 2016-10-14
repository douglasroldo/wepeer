<?php

class Matriz extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $disciplinacod_dis;

    /**
     *
     * @var integer
     */
    public $cursocodcur;

    /**
     *
     * @var integer
     */
    public $fasmat;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('cursocodcur', 'Curso', 'codcur', array('alias' => 'Curso'));
        $this->belongsTo('disciplinacod_dis', 'Disciplina', 'cod_dis', array('alias' => 'Disciplina'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'matriz';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Matriz[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Matriz
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
