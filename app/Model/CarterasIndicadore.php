<?php
App::uses('AppModel', 'Model');
/**
 * CarterasIndicadore Model
 *
 * @property Indicadores $Indicadores
 * @property Carteras $Carteras
 */
class CarterasIndicadore extends AppModel {

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
		'Indicadore' => array(
			'className' => 'Indicadore',
			'foreignKey' => 'indicadores_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Cartera' => array(
			'className' => 'Cartera',
			'foreignKey' => 'carteras_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
