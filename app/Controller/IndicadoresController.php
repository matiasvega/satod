<?php
App::uses('AppController', 'Controller');
/**
 * Indicadores Controller
 *
 * @property Indicadore $Indicadore
 * @property PaginatorComponent $Paginator
 */
class IndicadoresController extends AppController {

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
		$this->Indicadore->recursive = 0;
		$this->set('indicadores', $this->Paginator->paginate());
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
		if (!$this->Indicadore->exists($id)) {
			throw new NotFoundException(__('Invalid indicadore'));
		}
		$options = array('conditions' => array('Indicadore.' . $this->Indicadore->primaryKey => $id));
		$this->set('indicadore', $this->Indicadore->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                                   
		if ($this->request->is('post')) {                    

                        $data['Indicadore']['etiqueta'] = $this->request->data['Indicadore']['etiqueta'];
                        $data['Indicadore']['tipo'] = 'G';

                        for ($i=0;$i<=$this->request->data['Indicadore']['i'];$i++) {
                            $data['IndicadoresValore'][$i]['valor'] = $this->request->data['valor_'.$i];
                            $data['IndicadoresValore'][$i]['valor_ponderado'] = $this->request->data['valorPonderado_'.$i];
                        }
                        //pr($data);
                        $this->request->data = $data;
                        //pr($this->request->data);
                        //die('xxx');
                                            
			$this->Indicadore->create();
			if ($this->Indicadore->saveAll($this->request->data)) {
				$this->Session->setFlash(__('El Indicador ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		}
		//$carteras = $this->Indicadore->Cartera->find('list');
		//$this->set(compact('carteras'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Indicadore->exists($id)) {
			throw new NotFoundException(__('Invalid indicadore'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Indicadore->save($this->request->data)) {
				$this->Session->setFlash(__('El Indicador ha sido guardado.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('Indicadore.' . $this->Indicadore->primaryKey => $id));
			$this->request->data = $this->Indicadore->find('first', $options);
//                        dd($this->request->data);
		}
//		$carteras = $this->Indicadore->Cartera->find('list');
//		$this->set(compact('carteras'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Indicadore->id = $id;
		if (!$this->Indicadore->exists()) {
			throw new NotFoundException(__('Invalid indicadore'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Indicadore->delete()) {
			$this->Session->setFlash(__('El Indicador ha sido borrado.'), 'flash_ok');
		} else {
			$this->Session->setFlash(__('No se puede borra el indicador!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}}
