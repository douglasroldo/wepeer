<?php
class Curso extends \Phalcon\Mvc\Model {
	
	/**
	 *
	 * @var integer
	 */
	public $codcur;
	
	/**
	 *
	 * @var integer
	 */
	public $descur;
	
	/**
	 * Initialize method for model.
	 */
	public function initialize() {
		$this->setSchema ( "public" );
		$this->hasMany ( 'codcur', 'Matriz', 'cursocodcur', array (
				'alias' => 'Matriz' 
		) );
	}
	
	/**
	 * Returns table name mapped in the model.
	 *
	 * @return string
	 */
	public function getSource() {
		return 'curso';
	}
	
	/**
	 * Allows to query a set of records that match the specified conditions
	 *
	 * @param mixed $parameters        	
	 * @return Curso[]
	 */
	public static function find($parameters = null) {
		return parent::find ( $parameters );
	}
	
	/**
	 * Allows to query the first record that match the specified conditions
	 *
	 * @param mixed $parameters        	
	 * @return Curso
	 */
	public static function findFirst($parameters = null) {
		return parent::findFirst ( $parameters );
	}
}
