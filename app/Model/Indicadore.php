<?php
App::uses('AppModel', 'Model');
/**
 * Indicadore Model
 *
 * @property IndicadoresValore $IndicadoresValore
 * @property Cartera $Cartera
 */
class Indicadore extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'etiqueta';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'etiqueta' => array(
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
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'IndicadoresValore' => array(
			'className' => 'IndicadoresValore',
			'foreignKey' => 'indicadores_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	
        public $hasAndBelongsToMany = array(
		'Cartera' => array(
			'className' => 'Cartera',
			'joinTable' => 'carteras_indicadores',
			'foreignKey' => 'indicadores_id',
			'associationForeignKey' => 'carteras_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);
        
}
