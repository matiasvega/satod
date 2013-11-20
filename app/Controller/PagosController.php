<?php
App::uses('AppController', 'Controller');
/**
 * Pagos Controller
 *
 * @property Pago $Pago
 * @property PaginatorComponent $Paginator
 */
class PagosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

        public $helpers = array(
                            'Googlechart',
                        );  
        
        
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Pago->recursive = 0;
		$this->set('pagos', $this->Paginator->paginate());
	}
        
        public function indexCartera($carteras_id) {
                $conditions = array('Pago.carteras_id' => $carteras_id);
                $pagos = $this->Paginator->paginate($conditions);
                if (!empty($pagos)) {
                    $this->set('pagos', $pagos);
                } else {
                    $this->Session->setFlash(__('No se encuentran pagos registrados para la cartera seleccionada.'), 'flash_error');
                    return $this->redirect(array('controller' => 'carteras', action => 'index'));
                }
                
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Pago->exists($id)) {
			throw new NotFoundException(__('Invalid pago'));
		}
		$options = array('conditions' => array('Pago.' . $this->Pago->primaryKey => $id));
		$this->set('pago', $this->Pago->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Pago->create();
			if ($this->Pago->save($this->request->data)) {
				$this->Session->setFlash(__('The pago has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pago could not be saved. Please, try again.'));
			}
		}
		$carteras = $this->Pago->Cartera->find('list');
		$this->set(compact('carteras'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Pago->exists($id)) {
			throw new NotFoundException(__('Invalid pago'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Pago->save($this->request->data)) {
				$this->Session->setFlash(__('The pago has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The pago could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Pago.' . $this->Pago->primaryKey => $id));
			$this->request->data = $this->Pago->find('first', $options);
		}
		$carteras = $this->Pago->Cartera->find('list');
		$this->set(compact('carteras'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Pago->id = $id;
		if (!$this->Pago->exists()) {
			throw new NotFoundException(__('Invalid pago'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Pago->delete()) {
			$this->Session->setFlash(__('The pago has been deleted.'));
		} else {
			$this->Session->setFlash(__('The pago could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
        
        
        public function generarInformeDePagos() {
            if ($this->request->is('post')) {
                // Traigo los datos de la cartera, el cliente, los pagos que tenga, la planificacion y los indicadores
                $datos = $this->Pago->Cartera->find('all', array(
                    'conditions' => array(
                        'Cartera.id' => $this->request->data['Pago']['carteras_id'],
                    ),
                    'recursive' => 2
                        )
                );
//                dd($datos);                
                if (!key_exists('Pago', $datos[0])) {
                    $this->Session->setFlash(__('No se encontraron datos de pagos registrados para la cartera seleccionada.'), 'flash_error');
                }
                                

                $planificaciones = Set::classicExtract($datos, '{n}.Planificacione.{n}.id');
//                dd($planificaciones);
                // Busco cada detalle de planificacion con su correspondiente estrategia.
                $detallesPlanificaciones = ClassRegistry::init('DetallesPlanificacione')->find('all', array(
                    'conditions' => array(
                        'DetallesPlanificacione.planificaciones_id' => $planificaciones[0],
                                         ),
                    'recursive' => 1
                        )
                );
//                dd($detallesPlanificaciones);
                $indicadoresSeleccionados = Set::extract($detallesPlanificaciones, '{n}.DetallesPlanificacione.carteras_indicadores_id');

                $indicadores = ClassRegistry::init('IndicadoresValore')->find('list', array(
                    'fields' => array('IndicadoresValore.id', 'IndicadoresValore.valor'),
                    'conditions' => array('IndicadoresValore.id' => $indicadoresSeleccionados),
                    'recursive' => 0,
                ));
//                dd($indicadores);
                $this->set(compact('datos', 'detallesPlanificaciones', 'indicadores'));
                $this->render('comportamientoDePagos');
            }
            
            $clientes = $this->Pago->Cartera->Cliente->find('list');                                    
            $carteras = $this->Pago->Cartera->find('list', array(
                            'conditions' => array(
                                'Cartera.estado' => 'A',
                            ),
                        )
                    );
                        
            if (empty($clientes)){
                $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } else if (empty($carteras)) {
                $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados en estado "Asignada".'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } 
//            else if (empty($estrategias)) {
//                $this->Session->setFlash(__('No se encontraron datos de estrategias de gestion registrados.'), 'flash_error');
//                return $this->redirect(array('action' => 'index'));
//            } 
            else {
                $this->set(compact('clientes', 'carteras'/*, 'estrategias'*/));
            }
            
            
        }
        
        public function comportamientoDePagos() {
            
        }
                
        public function generarInformeDeRecupero() {
            if ($this->request->is('post')) {
                
                $datos = $this->Pago->Cartera->find('all', array(
                    'conditions' => array(
                        'Cartera.id' => $this->request->data['Pago']['carteras_id'],
                    ),
                    'recursive' => 2
                        )
                );
                
                foreach($datos as $dato) {
                    if (!key_exists('Pago', $dato)) {
                        $this->Session->setFlash(__('No se encontraron datos de pagos registrados para la/s cartera/s seleccionada/s.'), 'flash_error');
                    }    
                }                                
                
                $carteras = $this->Pago->Cartera->find('list', array(
                    'conditions' => array(
                        'Cartera.id' => $this->request->data['Pago']['carteras_id'],
                    )
                ));
                
                $planificaciones = Set::classicExtract($datos, '{n}.Planificacione.{n}.id');                             
//                dd($planificaciones);                
                $detallesPlanificaciones = ClassRegistry::init('DetallesPlanificacione')->find('all', array(
                    'conditions' => array(
                                                'DetallesPlanificacione.planificaciones_id' => $planificaciones[0],
                                         ),
                    'recursive' => 1
                        )
                );                
                
                $indicadoresSeleccionados = Set::extract($detallesPlanificaciones, '{n}.DetallesPlanificacione.carteras_indicadores_id');
                $indicadores = ClassRegistry::init('IndicadoresValore')->find('list', array(
                    'fields' => array('IndicadoresValore.id', 'IndicadoresValore.valor'),
                    'conditions' => array('IndicadoresValore.id' => $indicadoresSeleccionados),
                    'recursive' => 0,
                ));                              
                $this->set(compact('datos', 'detallesPlanificaciones', 'indicadores', 'carteras'));
//                $this->set(compact('datos'));
                $this->render('indiceDeRecupero');
            }
                        
            $clientes = $this->Pago->Cartera->Cliente->find('list');
            $carteras = $this->Pago->Cartera->find('list', array(
                            'conditions' => array(
                                'Cartera.estado' => 'A',
                            ),
                        )
                    );
            
            if (empty($clientes)){
                $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } else if (empty($carteras)) {
                $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados en estado "Asignada".'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } 
//            else if (empty($estrategias)) {
//                $this->Session->setFlash(__('No se encontraron datos de estrategias de gestion registrados.'), 'flash_error');
//                return $this->redirect(array('action' => 'index'));
//            } 
            else {
                $this->set(compact('clientes', 'carteras'/*, 'estrategias'*/));
            }                                                
                        
        }
        
        public function indiceDeRecupero() {
//            dd('xxxxxxxxxxxxxxxxxxxxxxxxx');
        }
        
        public function generarEfectividadEstrategias() {
            if ($this->request->is('post')) {
                
                $datos = $this->Pago->Cartera->find('all', array(
                    'conditions' => array(
                        'Cartera.id' => $this->request->data['Pago']['carteras_id'],
                    ),
                    'recursive' => 2
                        )
                );
                
//                dd($datos);
                foreach($datos as $dato) {
                    if (!key_exists('Pago', $dato)) {
                        $this->Session->setFlash(__('No se encontraron datos de pagos registrados para la/s cartera/s seleccionada/s.'), 'flash_error');
                    }    
                }                                
                
                $carteras = $this->Pago->Cartera->find('list', array(
                    'conditions' => array(
                        'Cartera.id' => $this->request->data['Pago']['carteras_id'],
                    )
                ));
                
                $planificaciones = Set::classicExtract($datos, '{n}.Planificacione.{n}.id');                             
//                dd($planificaciones);                
                $detallesPlanificaciones = ClassRegistry::init('DetallesPlanificacione')->find('all', array(
                    'conditions' => array(
                                                'DetallesPlanificacione.planificaciones_id' => $planificaciones[0],
                                         ),
                    'recursive' => 1
                        )
                );                
                
                $indicadoresSeleccionados = Set::extract($detallesPlanificaciones, '{n}.DetallesPlanificacione.carteras_indicadores_id');
                $indicadores = ClassRegistry::init('IndicadoresValore')->find('all', array(
                    'fields' => array('IndicadoresValore.id', 'IndicadoresValore.valor', 'IndicadoresValore.valor_ponderado'),
//                    'fields' => array('IndicadoresValore.id', 'IndicadoresValore.valor'),
                    'conditions' => array('IndicadoresValore.id' => $indicadoresSeleccionados),
                    'recursive' => 0,
                ));
                
                $indicadoresAux = null;
                foreach ($indicadores as $indicador) {
                    $indicadoresAux[$indicador['IndicadoresValore']['id']] = $indicador;
                }
                $indicadores = $indicadoresAux;
                
                $this->set(compact('datos', 'detallesPlanificaciones', 'indicadores', 'carteras'));                
//                $this->set(compact('datos'));
                $this->render('efectividadDeEstrategias');
            }
                        
            $clientes = $this->Pago->Cartera->Cliente->find('list');
            $carteras = $this->Pago->Cartera->find('list', array(
                            'conditions' => array(
                                'Cartera.estado' => 'A',
                            ),
                        )
                    );
            
            if (empty($clientes)){
                $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } else if (empty($carteras)) {
                $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados en estado "Asignada".'), 'flash_error');
                return $this->redirect(array('action' => 'index'));
            } 
            else {
                $this->set(compact('clientes', 'carteras'/*, 'estrategias'*/));
            }                                                
                        
        }
        
        
        public function buscarIndicadores($accionController) {
            // Permite mostrar los indicadores de recupero definidos para una cartera.
//            d($this->request->data);            
            $joins = array(
                array(
                    'table' => 'carteras_indicadores',
                    'alias' => 'CarterasIndicadores',
                    'type' => 'inner',
                    'conditions' => array('Indicadore.id = CarterasIndicadores.indicadores_id')
                ),
                array(
                    'table' => 'carteras',
                    'alias' => 'Cartera',
                    'type' => 'inner',
                    'conditions' => array('CarterasIndicadores.carteras_id = Cartera.id')
                ),
            );


            $indicadores = $this->Pago->Cartera->Indicadore->find('list', array(
                'conditions' => array(
                    'CarterasIndicadores.carteras_id' => $this->request->data['Pago']['carteras_id'],
                    'Indicadore.tipo' => 'P',
                    'Indicadore.calculo' => 'group',
                ),
                'joins' => $joins,
                'recursive' => 0
                    )
            );
            
            if (!empty($indicadores)) {
                $this->set(compact('indicadores'));
            } else {
                $this->Session->setFlash(__('No se encontraron indicadores de recupero definidos para la cartera de deudores seleccionada.'), 'flash_error');           
                $accion = $accionController;
                $this->set('accion', $accion);
            }
            
            //$this->render('datos');
        }
                        
}      