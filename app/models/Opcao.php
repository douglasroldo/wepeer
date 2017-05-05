<?php

class Opcao extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Column(type="integer", length=32, nullable=true)
     */
    public $perguntacodper;

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=32, nullable=false)
     */
    public $codopc;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $desopc;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("public");
        $this->hasMany('codopc', 'Peerrespostas', 'opcaocodopc', ['alias' => 'Peerrespostas']);
        $this->belongsTo('perguntacodper', 'Pergunta', 'codper', ['alias' => 'Pergunta']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'opcao';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Opcao[]
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Opcao
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
