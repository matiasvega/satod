<?php
App::uses('AppController', 'Controller');
/**
 * Estrategias Controller
 *
 * @property Estrategia $Estrategia
 * @property PaginatorComponent $Paginator
 */
class EstrategiasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
        public $helpers = array('Tree');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Estrategia->recursive = 0;
		$this->set('estrategias', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Estrategia->exists($id)) {
			throw new NotFoundException(__('Invalid estrategia'));
		}
		$options = array('conditions' => array('Estrategia.' . $this->Estrategia->primaryKey => $id));
		$this->set('estrategia', $this->Estrategia->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
                $costos = ClassRegistry::init('Costo')->find('threaded', array( 
                                                                'order' => array(
                                                                            'Costo.lft' => 'ASC'), 
                                                                            'recursive' => -1
                                                                                )
                                                            );

                if (!empty($costos)) {
                    $costosVariables = array();
                    foreach ($costos as $k => $costoPadre) {
                        if (array_key_exists('children', $costoPadre)) {
                            $costosJson[$k]['title'] = $costoPadre['Costo']['nombre'];
                            $costosJson[$k]['isFolder'] = true;
                            $costosJson[$k]['key'] = $costoPadre['Costo']['id'];
                            $costosJson[$k]['expand'] = true;

                            foreach ($costoPadre['children'] as $kk => $children) {
                                $labelCosto = sprintf('<label> %s </label>', $children['Costo']['nombre']);
                                $inputMultiplicador = false;
                                if($children['Costo']['tipo'] == 'V') {
                                    $labelCosto = sprintf('<label for="multiplicador_%s"> %s </label>', $children['Costo']['id'], $children['Costo']['nombre']);
                                    $costosJson[$k]['children'][$kk]['tooltip'] = "Ingresar multiplicador";
                                    $inputMultiplicador = sprintf('<input type="number" id="multiplicador_%s" name="multiplicador%s" placeholder="Ingresa un valor multiplicador." class="inputMultiplicador"/>', $children['Costo']['id'], $children['Costo']['id']);
                                    $costosVariables[] = $children['Costo']['id'];
                                }
                                                                
                                $costosJson[$k]['children'][$kk]['title'] = sprintf('<div class="seleccionCostos"> %s %s </div>', $labelCosto, $inputMultiplicador);

                                $costosJson[$k]['children'][$kk]['key'] = $children['Costo']['id'];
                                $costosJson[$k]['children'][$kk]['noLink'] = true;
                            }
                        }
                    }
                    $costosJson = json_encode($costosJson);                    
                } else {
                    $this->Session->setFlash(__('No se encontraron costos registrados. Para poder dar de alta una estrategia, deben existir los costos correspondientes registrados.'), 'flash_error');
                    return $this->redirect(array('action' => 'index'));
                }
                
                $this->set('costosJson', $costosJson);
                $this->set('costosVariables', $costosVariables);
                 
		if ($this->request->is('post')) {
                        $data['Estrategia']['nombre'] = $this->request->data['Estrategia']['nombre'];
                        $data['Estrategia']['descripcion'] = $this->request->data['Estrategia']['descripcion'];
                        $costosSeleccionados = explode(",", $this->request->data['Estrategia']['costosSeleccionados']);
                                                
                        $i = 0;
                        foreach ($costosSeleccionados as $costoSeleccionado) {
                            $data['Costo'][$i]['costos_id'] = $costoSeleccionado;
                            $indice = sprintf('multiplicador%s', trim($costoSeleccionado));
                            $data['Costo'][$i]['multiplicador'] = (isset($this->request->data[$indice]))?$this->request->data[$indice]:0;
                            $i++;
                        }
                                                                                               
                        $this->request->data = $data;                                        
			$this->Estrategia->create();
			if ($this->Estrategia->save($this->request->data)) {
                                $this->Session->setFlash(__('La Estrategia ha sido guardada.'), 'flash_ok');
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
		if (!$this->Estrategia->exists($id)) {
			throw new NotFoundException(__('Invalid estrategia'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Estrategia->save($this->request->data)) {
				$this->Session->setFlash(__('La Estrategia ha sido guardada.'), 'flash_ok');
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
			}
		} else {
			$options = array('conditions' => array('Estrategia.' . $this->Estrategia->primaryKey => $id));
			$this->request->data = $this->Estrategia->find('first', $options);
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
		$this->Estrategia->id = $id;
		if (!$this->Estrategia->exists()) {
			throw new NotFoundException(__('Invalid estrategia'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Estrategia->delete()) {
                        $this->Session->setFlash(__('La estrategia ha sido borrada.'), 'flash_ok');
		} else {
			$this->Session->setFlash(__('No se puede borra la estrategia!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
		}
		return $this->redirect(array('action' => 'index'));
	}}
