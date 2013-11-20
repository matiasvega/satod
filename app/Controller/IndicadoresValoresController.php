<?php
App::uses('AppController', 'Controller');
/**
 * IndicadoresValores Controller
 *
 * @property IndicadoresValore $IndicadoresValore
 * @property PaginatorComponent $Paginator
 */
class IndicadoresValoresController extends AppController {

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
		$this->IndicadoresValore->recursive = 0;
		$this->set('indicadoresValores', $this->Paginator->paginate());
	}

        public function indexIndicador($indicador_id) {
                $conditions = array('IndicadoresValore.indicadores_id' => $indicador_id);
                $this->set('indicadoresValores', $this->Paginator->paginate($conditions));
	}
        
        
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->IndicadoresValore->exists($id)) {
			throw new NotFoundException(__('Invalid indicadores valore'));
		}
		$options = array('conditions' => array('IndicadoresValore.' . $this->IndicadoresValore->primaryKey => $id));
		$this->set('indicadoresValore', $this->IndicadoresValore->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->IndicadoresValore->create();
			if ($this->IndicadoresValore->save($this->request->data)) {
				$this->Session->setFlash(__('The indicadores valore has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The indicadores valore could not be saved. Please, try again.'));
			}
		}
		$indicadores = $this->IndicadoresValore->Indicadore->find('list');
		$this->set(compact('indicadores'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null, $idIndicador = false) {
		if (!$this->IndicadoresValore->exists($id)) {
			throw new NotFoundException(__('Invalid indicadores valore'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->IndicadoresValore->save($this->request->data)) {
				$this->Session->setFlash(__('El valor de indicador ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'indexIndicador', $idIndicador));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('IndicadoresValore.' . $this->IndicadoresValore->primaryKey => $id));
			$this->request->data = $this->IndicadoresValore->find('first', $options);
		}
		$indicadores = $this->IndicadoresValore->Indicadore->find('list');
		$this->set(compact('indicadores'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null, $idIndicador = false) {
		$this->IndicadoresValore->id = $id;
		if (!$this->IndicadoresValore->exists()) {
			throw new NotFoundException(__('Invalid indicadores valore'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->IndicadoresValore->delete()) {
                        $this->Session->setFlash(__('El valor del Indicador ha sido borrado.'), 'flash_ok');
		} else {
			$this->Session->setFlash(__('No se puede borra el valor del indicador!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'indexIndicador', $idIndicador));
	}}
