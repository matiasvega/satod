<?php
App::uses('AppModel', 'Model');
/**
 * IndicadoresValore Model
 *
 * @property Indicadores $Indicadores
 */
class IndicadoresValore extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'valor' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'valor_ponderado' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'Indicadore' => array(
			'className' => 'Indicadore',
			'foreignKey' => 'indicadores_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
