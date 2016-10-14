<?php

class Peerperguntas extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $perguntacodper;

    /**
     *
     * @var integer
     */
    public $peercodpee;

    /**
     *
     * @var integer
     */
    public $ordpee;

    /**
     *
     * @var integer
     */
    public $obrirespeer;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('perguntacodper', 'Pergunta', 'codper', array('alias' => 'Pergunta'));
        $this->belongsTo('peercodpee', 'Peer', 'codpee', array('alias' => 'Peer'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'peerperguntas';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peerperguntas[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peerperguntas
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
