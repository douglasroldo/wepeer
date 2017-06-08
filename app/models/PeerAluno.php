<?php

class PeerAluno extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $peercodpee;

    /**
     *
     * @var integer
     */
    public $alunocod_matricula;

    /**
     *
     * @var string
     */
    public $datexecpeer;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->belongsTo('alunocod_matricula', 'Aluno', 'codmat', array('alias' => 'Aluno'));
        $this->belongsTo('peercodpee', 'Peer', 'codpee', array('alias' => 'Peer'));
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'peeraluno';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeerAluno[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PeerAluno
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
