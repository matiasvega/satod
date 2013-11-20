<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Cliente->recursive = 0;
		$this->set('clientes', $this->Paginator->paginate());

                $this->set('estados', array('P' => 'Potencial', 'E' => 'Efectivo'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
		$this->set('cliente', $this->Cliente->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Cliente->create();
			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash(__('El cliente ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
                                $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {            
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
                        if (!isset($this->request->data['Cliente']['idLogisis'])) {
                            $this->request->data['Cliente']['idLogisis'] = "";
                        }
			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash(__('El cliente ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cliente->delete()) {
			$this->Session->setFlash(__('El cliente ha sido borrado.'), 'flash_ok');
                        
		} else {
			$this->Session->setFlash(__('No se puede borra el cliente!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}}
