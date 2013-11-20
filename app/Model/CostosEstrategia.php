<?php
App::uses('AppModel', 'Model');
/**
 * CostosEstrategia Model
 *
 * @property Costos $Costos
 * @property Estrategias $Estrategias
 */
class CostosEstrategia extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'multiplicador';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'multiplicador' => array(
			'decimal' => array(
				'rule' => array('decimal'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Costos' => array(
			'className' => 'Costos',
			'foreignKey' => 'costos_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Estrategias' => array(
			'className' => 'Estrategias',
			'foreignKey' => 'estrategias_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
