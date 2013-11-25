<?php

App::uses('AppController', 'Controller');

class UsersController extends AppController {

//    public function beforeFilter() {
//        parent::beforeFilter();
//        $this->Auth->allow('login');
//    }
    
    public function beforeFilter() {
//        parent::beforeFilter();
//        $this->Auth->allow('login');
//        $this->Auth->allow('initDB');
    }
    


    public function index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
        $this->set('grupos', $this->User->Group->find('list'));
    }

    public function view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El usuario ha sido guardado.'), 'flash_ok');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        }
        $grupos = $this->User->Group->find('list');        
        $this->set('grupos', $grupos);
    }

    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El usuario ha sido guardado.'), 'flash_ok');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
        $grupos = $this->User->Group->find('list');        
        $this->set('grupos', $grupos);
    }
    
        public function options($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('El usuario ha sido guardado.'), 'flash_ok');
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        } else {
            $this->request->data = $this->User->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('El usuario ha sido borrado.'), 'flash_ok');
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('No se puede borrar el usuario!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        return $this->redirect(array('action' => 'index'));
    }
    
    
    public function login() {
        $this->layout = 'login';
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Nombre de Usuario o Contraseña incorrecto.'), 'flash_error');
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
    
    public function initDB() {
        $group = $this->User->Group;
        // Administrador -> acceso a todo
        $group->id = 1;
        $this->Acl->allow($group, 'controllers');
        
        // Jefe Operativo -> acceso a: Costos de gestion,....
//        $group->id = 2;
//        $this->Acl->deny($group, 'controllers');
//        $this->Acl->allow($group, 'controllers/Costos');
//        $this->Acl->allow($group, 'controllers/Indicadores');
//        $this->Acl->allow($group, 'controllers/Estrategias');
//        $this->Acl->allow($group, 'controllers/Carteras');
//        
//
//        //Asesor Comercial -> acceso a: Clientes
//        $group->id = 3;
//        $this->Acl->deny($group, 'controllers');
//        $this->Acl->allow($group, 'controllers/Clientes');
//        
//        $this->Acl->allow($group, 'controllers/Users/logout');
//        $this->Acl->allow($group, 'controllers/Users/options');
        
        
        //we add an exit to avoid an ugly "missing views" error message
        echo "all done";
        exit;
    }
    
    public function indexGroups() {
        return $this->redirect(array(
                                    'controller' => 'groups',
                                    'action' => 'index',
                                    )
                                );
    }
    
    public function addGroup() {
        return $this->redirect(array(
                                    'controller' => 'groups',
                                    'action' => 'add',
                                    )
                                );
    }
    
    public function indexPriv() {
        return $this->redirect('/admin/acl');
    }
    
}

