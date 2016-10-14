<?php

class Categoria extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $codcat;

    /**
     *
     * @var string
     */
    public $descat;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codcat', 'Pergunta', 'categoriacodcat', array('alias' => 'Pergunta'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'categoria';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categoria[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Categoria
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
