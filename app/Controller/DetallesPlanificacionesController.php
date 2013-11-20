<?php
App::uses('AppController', 'Controller');
/**
 * DetallesPlanificaciones Controller
 *
 * @property DetallesPlanificacione $DetallesPlanificacione
 * @property PaginatorComponent $Paginator
 */
class DetallesPlanificacionesController extends AppController {

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
		$this->DetallesPlanificacione->recursive = 0;
		$this->set('detallesPlanificaciones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->DetallesPlanificacione->exists($id)) {
			throw new NotFoundException(__('Invalid detalles planificacione'));
		}
		$options = array('conditions' => array('DetallesPlanificacione.' . $this->DetallesPlanificacione->primaryKey => $id));
		$this->set('detallesPlanificacione', $this->DetallesPlanificacione->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DetallesPlanificacione->create();
			if ($this->DetallesPlanificacione->save($this->request->data)) {
				$this->Session->setFlash(__('The detalles planificacione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The detalles planificacione could not be saved. Please, try again.'));
			}
		}
		$estrategias = $this->DetallesPlanificacione->Estrategia->find('list');
		$carterasIndicadores = $this->DetallesPlanificacione->CarterasIndicadore->find('list');
		$planificaciones = $this->DetallesPlanificacione->Planificacione->find('list');
		$this->set(compact('estrategias', 'carterasIndicadores', 'planificaciones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->DetallesPlanificacione->exists($id)) {
			throw new NotFoundException(__('Invalid detalles planificacione'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DetallesPlanificacione->save($this->request->data)) {
				$this->Session->setFlash(__('The detalles planificacione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The detalles planificacione could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('DetallesPlanificacione.' . $this->DetallesPlanificacione->primaryKey => $id));
			$this->request->data = $this->DetallesPlanificacione->find('first', $options);
		}
		$estrategias = $this->DetallesPlanificacione->Estrategia->find('list');
		$carterasIndicadores = $this->DetallesPlanificacione->CarterasIndicadore->find('list');
		$planificaciones = $this->DetallesPlanificacione->Planificacione->find('list');
		$this->set(compact('estrategias', 'carterasIndicadores', 'planificaciones'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->DetallesPlanificacione->id = $id;
		if (!$this->DetallesPlanificacione->exists()) {
			throw new NotFoundException(__('Invalid detalles planificacione'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->DetallesPlanificacione->delete()) {
			$this->Session->setFlash(__('The detalles planificacione has been deleted.'));
		} else {
			$this->Session->setFlash(__('The detalles planificacione could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
