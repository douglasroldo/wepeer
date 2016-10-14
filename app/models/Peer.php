<?php

class Peer extends \Phalcon\Mvc\Model
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
    public $codpee;

    /**
     *
     * @var string
     */
    public $despee;

    /**
     *
     * @var string
     */
    public $datcadpee;

    /**
     *
     * @var string
     */
    public $dasexepee;

    /**
     *
     * @var string
     */
    public $dasfimpee;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codpee', 'PeerAluno', 'peercodpee', array('alias' => 'PeerAluno'));
        $this->hasMany('codpee', 'Peerperguntas', 'peercodpee', array('alias' => 'Peerperguntas'));
        $this->belongsTo('turmacodtur', 'Turma', 'codtur', array('alias' => 'Turma'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'peer';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peer[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Peer
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
