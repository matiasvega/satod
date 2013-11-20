<?php
App::uses('AppModel', 'Model');
/**
 * Costo Model
 *
 * @property Costos $Costos
 */
class Costo extends AppModel {
    
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'nombre';
        
/**
 * Behaviors
 *
 * @var string
 */
        public $actsAs = array('Tree');

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
