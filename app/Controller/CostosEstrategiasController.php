<?php
App::uses('AppController', 'Controller');
/**
 * CostosEstrategias Controller
 *
 * @property CostosEstrategia $CostosEstrategia
 * @property PaginatorComponent $Paginator
 */
class CostosEstrategiasController extends AppController {

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
		$this->CostosEstrategia->recursive = 0;
		$this->set('costosEstrategias', $this->Paginator->paginate());
	}
        
        public function indexEstrategia($estrategia_id) {                
                $conditions = array('CostosEstrategia.estrategias_id' => $estrategia_id);
                $this->set('costosEstrategias', $this->Paginator->paginate($conditions));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CostosEstrategia->exists($id)) {
			throw new NotFoundException(__('Invalid costos estrategia'));
		}
		$options = array('conditions' => array('CostosEstrategia.' . $this->CostosEstrategia->primaryKey => $id));
		$this->set('costosEstrategia', $this->CostosEstrategia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CostosEstrategia->create();
			if ($this->CostosEstrategia->save($this->request->data)) {
				$this->Session->setFlash(__('The costos estrategia has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The costos estrategia could not be saved. Please, try again.'));
			}
		}
		$costos = $this->CostosEstrategia->Costo->find('list');
		$estrategias = $this->CostosEstrategia->Estrategia->find('list');
		$this->set(compact('costos', 'estrategias'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null, $idEstrategia = false) {
		if (!$this->CostosEstrategia->exists($id)) {
			throw new NotFoundException(__('Invalid costos estrategia'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CostosEstrategia->save($this->request->data)) {
                                $this->Session->setFlash(__('El costo ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'indexEstrategia', $idEstrategia));
			} else {
                                $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('CostosEstrategia.' . $this->CostosEstrategia->primaryKey => $id));
			$this->request->data = $this->CostosEstrategia->find('first', $options);
		}
//		$costos = $this->CostosEstrategia->Costo->find('list');
//		$estrategias = $this->CostosEstrategia->Estrategia->find('list');
		$this->set(compact('costos', 'estrategias'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $idEstrategia = false) {
		$this->CostosEstrategia->id = $id;
		if (!$this->CostosEstrategia->exists()) {
			throw new NotFoundException(__('Invalid costos estrategia'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CostosEstrategia->delete()) {
                        $this->Session->setFlash(__('El costo ha sido borrado.'), 'flash_ok');
		} else {
			$this->Session->setFlash(__('No se puede borrar el costo!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
                return $this->redirect(array('action' => 'indexEstrategia', $idEstrategia));
	}}
