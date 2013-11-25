<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    public $actsAs = array('Acl' => array('type' => 'requester'));
    
    public function parentNode() {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        if (isset($this->data['User']['group_id'])) {
            $groupId = $this->data['User']['group_id'];
        } else {
            $groupId = $this->field('group_id');
        }
        if (!$groupId) {
            return null;
        } else {
            return array('Group' => array('id' => $groupId));
        }
    }
    
    
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo requerido'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Campo requerido'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'joperativo', 'jcalidad', 'acomercial', 'director')),
                'message' => 'Selecciona un rol valido.',
                'allowEmpty' => false
            )
        )
    );
    
    public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
    
    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
        }
        return true;
    }
    
    
    
    
}
?>