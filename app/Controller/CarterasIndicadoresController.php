<?php
App::uses('AppController', 'Controller');
/**
 * CarterasIndicadores Controller
 *
 * @property CarterasIndicadore $CarterasIndicadore
 * @property PaginatorComponent $Paginator
 */
class CarterasIndicadoresController extends AppController {

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
		$this->CarterasIndicadore->recursive = 0;
		$this->set('carterasIndicadores', $this->Paginator->paginate());
	}
        
        public function indexCartera($cartera_id) {                
                $conditions = array('CarterasIndicadore.carteras_id' => $cartera_id);
                $this->set('carterasIndicadores', $this->Paginator->paginate($conditions));
                $this->set('tipoIndicadores', array('G' => 'General', 'P' => 'Particular'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->CarterasIndicadore->exists($id)) {
			throw new NotFoundException(__('Invalid carteras indicadore'));
		}
		$options = array('conditions' => array('CarterasIndicadore.' . $this->CarterasIndicadore->primaryKey => $id));
		$this->set('carterasIndicadore', $this->CarterasIndicadore->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CarterasIndicadore->create();
			if ($this->CarterasIndicadore->save($this->request->data)) {
				$this->Session->setFlash(__('The carteras indicadore has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carteras indicadore could not be saved. Please, try again.'));
			}
		}
		$indicadores = $this->CarterasIndicadore->Indicadore->find('list');
		$carteras = $this->CarterasIndicadore->Cartera->find('list');
		$this->set(compact('indicadores', 'carteras'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->CarterasIndicadore->exists($id)) {
			throw new NotFoundException(__('Invalid carteras indicadore'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CarterasIndicadore->save($this->request->data)) {
				$this->Session->setFlash(__('The carteras indicadore has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carteras indicadore could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CarterasIndicadore.' . $this->CarterasIndicadore->primaryKey => $id));
			$this->request->data = $this->CarterasIndicadore->find('first', $options);
		}
		$indicadores = $this->CarterasIndicadore->Indicadore->find('list');
		$carteras = $this->CarterasIndicadore->Cartera->find('list');
		$this->set(compact('indicadores', 'carteras'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->CarterasIndicadore->id = $id;
		if (!$this->CarterasIndicadore->exists()) {
			throw new NotFoundException(__('Invalid carteras indicadore'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->CarterasIndicadore->delete()) {
                        $this->Session->setFlash(__('El indicador se desvinculo de la cartera.'), 'flash_ok');
		} else {
                        $this->Session->setFlash(__('No se puede desvincular el indicador de la cartera de deudores!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}}
