<?php

class Pergunta extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $categoriacodcat;

    /**
     *
     * @var integer
     */
    public $codper;

    /**
     *
     * @var string
     */
    public $desper;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codper', 'Opcao', 'perguntacodper', array('alias' => 'Opcao'));
        $this->hasMany('codper', 'Peerperguntas', 'perguntacodper', array('alias' => 'Peerperguntas'));
        $this->belongsTo('categoriacodcat', 'Categoria', 'codcat', array('alias' => 'Categoria'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'pergunta';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pergunta[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Pergunta
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
