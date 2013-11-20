<?php
App::uses('AppController', 'Controller');
/**
 * Costos Controller
 *
 * @property Costo $Costo
 * @property PaginatorComponent $Paginator
 */
class CostosController extends AppController {

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
		$this->Costo->recursive = 0;
		$this->set('costos', $this->Paginator->paginate());
                $this->set('listaCostos', $this->Costo->find('list')); 
                
                 $this->set('tipoCostos', array('F' => 'Fijo', 'V' => 'Variable'));
	}
                
        public function tree() {
              $costos = $this->Costo->generateTreeList(null, null, null, '&nbsp;&nbsp;&nbsp;');
              $this->set('costos', $costos);            
        }
         
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Costo->exists($id)) {
			throw new NotFoundException(__('Invalid costo'));
		}
		$options = array('conditions' => array('Costo.' . $this->Costo->primaryKey => $id));
		$this->set('costo', $this->Costo->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $this->set('listaCostos', $this->Costo->find('list'));
		if ($this->request->is('post')) {
			$this->Costo->create();
			if ($this->Costo->save($this->request->data)) {                            
				$this->Session->setFlash(__('El Costo ha sido guardado.'), 'flash_ok');
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
                $this->set('listaCostos', $this->Costo->find('list'));
		if (!$this->Costo->exists($id)) {
			throw new NotFoundException(__('Invalid costo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Costo->save($this->request->data)) {
				$this->Session->setFlash(__('El Costo ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('Costo.' . $this->Costo->primaryKey => $id));
			$this->request->data = $this->Costo->find('first', $options);
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
		$this->Costo->id = $id;
		if (!$this->Costo->exists()) {
			throw new NotFoundException(__('Invalid costo'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Costo->delete()) {
			$this->Session->setFlash(__('El Costo ha sido borrado.'), 'flash_ok');
		} else {
			$this->Session->setFlash(__('No se puede borra el costo!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}}
