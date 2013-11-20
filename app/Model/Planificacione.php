<?php
App::uses('AppModel', 'Model');
/**
 * Planificacione Model
 *
 * @property Carteras $Carteras
 * @property DetallesPlanificacione $DetallesPlanificacione
 */
class Planificacione extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cartera' => array(
			'className' => 'Cartera',
			'foreignKey' => 'carteras_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'DetallesPlanificacione' => array(
			'className' => 'DetallesPlanificacione',
			'foreignKey' => 'planificaciones_id',
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

}
