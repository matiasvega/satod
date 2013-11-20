<?php
App::uses('AppModel', 'Model');
/**
 * Cliente Model
 *
 */
class Cliente extends AppModel {
    
/**
 * Display field
 *
 * @var string
 */
    public $displayField = 'nombre';
    
    
    public $validate = array(
        'nombre' => array(
            'alphaNumeric' => array(
                'rule'     => 'notEmpty',
                'required' => false,
                'message'  => 'Este campo es requerido, ingresa el valor correspondiente.'
            ),
        )
    );
}
