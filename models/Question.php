<?php
class Question extends ObjectModel
{
 	/** @var string Name */
	public $id_answerandwin;
	public $question;
	public $response;
	public $fk_id_rule;
	
// 	public $count_offer;
// 	public $count_offer;
// 	public $max_offer;
// 	public $active;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'answerandwin',
		'primary' => 'id_answerandwin',
		'multilang' => false,
		'fields' => array(
			// Lang fields
			'question' => 		array('type' => self::TYPE_STRING,'validate' => 'isGenericName', 'required' => true, 'size' => 64),
			'response' => 		array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => false, 'size' => 64),
			'fk_id_rule' => 		array('type' => self::TYPE_INT),
		),
	);
}