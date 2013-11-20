<?php
App::uses('AppModel', 'Model');
/**
 * DetallesPlanificacione Model
 *
 * @property Estrategias $Estrategias
 * @property CarterasIndicadores $CarterasIndicadores
 * @property Planificaciones $Planificaciones
 */
class DetallesPlanificacione extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
//		'fecha_inicio' => array(
//			'date' => array(
//				'rule' => array('date'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
//		'fecha_fin' => array(
//			'date' => array(
//				'rule' => array('date'),
//				//'message' => 'Your custom message here',
//				//'allowEmpty' => false,
//				//'required' => false,
//				//'last' => false, // Stop validation after this rule
//				//'on' => 'create', // Limit validation to 'create' or 'update' operations
//			),
//		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Estrategia' => array(
			'className' => 'Estrategia',
			'foreignKey' => 'estrategias_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'CarterasIndicadore' => array(
			'className' => 'CarterasIndicadore',
			'foreignKey' => 'carteras_indicadores_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Planificacione' => array(
			'className' => 'Planificacione',
			'foreignKey' => 'planificaciones_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
