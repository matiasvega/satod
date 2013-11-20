<?php

App::uses('AppController', 'Controller');

/**
 * Planificaciones Controller
 *
 * @property Planificacione $Planificacione
 * @property PaginatorComponent $Paginator
 */
class PlanificacionesController extends AppController {

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
        $this->Planificacione->recursive = 2;
        $this->set('planificaciones', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Planificacione->exists($id)) {
            throw new NotFoundException(__('Invalid planificacione'));
        }
        $options = array('conditions' => array('Planificacione.' . $this->Planificacione->primaryKey => $id));
        $this->set('planificacione', $this->Planificacione->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {            
            if (!empty($this->request->data['DetallesPlanificacione'])) {
                $data['Planificacione']['carteras_id'] = $this->request->data['Planificacione']['carteras_id'];
                $data['Planificacione']['fecha_inicio'] = fechadB($this->request->data['Planificacione']['fecha_inicio']);
                $data['Planificacione']['fecha_fin'] = fechadB($this->request->data['Planificacione']['fecha_fin']);
                foreach ($this->request->data['DetallesPlanificacione'] as $DetallesPlanificacione) {
                    if ($DetallesPlanificacione['fecha_inicio'] != '' && $DetallesPlanificacione['estrategias_id']) {
                        $DetallesPlanificacione['fecha_inicio'] = fechadB($DetallesPlanificacione['fecha_inicio']);
                        $DetallesPlanificacione['fecha_fin'] = fechadB($DetallesPlanificacione['fecha_fin']);
                        $data['DetallesPlanificacione'][] = $DetallesPlanificacione;
                    }
                }                                
            }
                        
            if (array_key_exists('DetallesPlanificacione', $data)) {
                $this->request->data = $data;
                $this->Planificacione->create();                        

                if ($this->Planificacione->saveAll($this->request->data)) {
                    $this->Session->setFlash(__('Los datos de la planificacion han sido guardados.'), 'flash_ok');
                    $newPlanificacion = $this->Planificacione->id;
                    return $this->redirect(array('action' => sprintf('generarGantt/%s', $newPlanificacion)));                
                } else {
                    $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
                }                
            }            
        }

        $carteras = $this->Planificacione->Cartera->find('list');
        $clientes = $this->Planificacione->Cartera->Cliente->find('list');
        
        if (empty($clientes)){
            $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else if (empty($carteras)) {
            $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->set(compact('carteras', 'clientes'));    
        }
                
    }
    
    public function buscarIndicadores() {
        // Permite mostrar los indicadores de recupero definidos para una cartera, cuando se planifica la gestion
        // Muestro los indicadores de recupero con los campos de fecha y estrategia 
        // para que el usuario pueda definir la estrategia a aplicar sobre cada indicador.
        $estrategias = ClassRegistry::init('Estrategia')->find('list');

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

        $indicadores = $this->Planificacione->Cartera->Indicadore->find('all', array(
            'conditions' => array(
                'CarterasIndicadores.carteras_id' => $this->request->data['Planificacione']['carteras_id'],
                'Indicadore.tipo' => 'P',
                'Indicadore.calculo' => 'group',
            ),
            'joins' => $joins,
            'recursive' => 2
                )
        );
                
        if (empty($estrategias)){
            $this->Session->setFlash(__('No se encontraron datos de estrategias de gestion registrados.'), 'flash_error');            
        } else if (empty($indicadores)) {
            $this->Session->setFlash(__('No se encontraron datos de indicadores de recupero registrados.'), 'flash_error');
        } else {
            $this->set(compact('indicadores', 'estrategias'));
        }
                
        //$this->render('datos');
    }

    public function generarGantt($planificacion_id) {

        $planificacion = $this->Planificacione->find('first', array(
            'conditions' => array('Planificacione.id' => $planificacion_id),
            'recursive' => 2,
        ));
//        dd($planificacion);
        $this->pdfConfig = array(
            'orientation' => 'portrait',
            'download' => true,
            'filename' => sprintf('planificacion_%s.pdf', str_replace(' ', '_', $planificacion['Cartera']['nombre'])),
        );

//        $planificacion = $this->Planificacione->find('all', array(
//            'conditions' => array('Planificacione.id' => $planificacion_id),
//            'recursive' => 2,
//        ));
        
        $indicadoresSeleccionados = Set::extract($planificacion, 'DetallesPlanificacione.{n}.carteras_indicadores_id');        

        $indicadores = ClassRegistry::init('IndicadoresValore')->find('list', array(
            'fields' => array('IndicadoresValore.id', 'IndicadoresValore.valor'),
            'conditions' => array('IndicadoresValore.id' => $indicadoresSeleccionados),
            'recursive' => 0,
        ));

        $datos['Planificacion'] = $planificacion;
        $datos['IndicadoresSeleccionados'] = $indicadores;
        foreach ($planificacion['DetallesPlanificacione'] as $k => $detalle) {

            $fecha_inicio = explode('-', $detalle['fecha_inicio']);
            $fecha_fin = explode('-', $detalle['fecha_fin']);

            $aux[$k]['item'] = sprintf("'%s'", $k + 1);
            $aux[$k]['etiqueta'] = sprintf("'%s'", $detalle['Estrategia']['nombre']);
            $aux[$k]['fecha_inicio'] = sprintf('new Date(%s, %s, %s)', date('Y', mktime(0, 0, 0, $fecha_inicio[1] - 1, $fecha_inicio[2], $fecha_inicio[0])), date('n', mktime(0, 0, 0, $fecha_inicio[1] - 1, $fecha_inicio[2], $fecha_inicio[0])), date('j', mktime(0, 0, 0, $fecha_inicio[1] - 1, $fecha_inicio[2], $fecha_inicio[0]))
            );

            $aux[$k]['fecha_fin'] = sprintf('new Date(%s, %s, %s)', date('Y', mktime(0, 0, 0, $fecha_fin[1] - 1, $fecha_fin[2], $fecha_fin[0])), date('n', mktime(0, 0, 0, $fecha_fin[1] - 1, $fecha_fin[2], $fecha_fin[0])), date('j', mktime(0, 0, 0, $fecha_fin[1] - 1, $fecha_fin[2], $fecha_fin[0]))
            );
        }

        foreach ($aux as $auxDetalle) {
            $datos['Gantt'][] = sprintf('[%s]', implode(",", $auxDetalle));
        }

        $this->set('datos', $datos);
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Planificacione->exists($id)) {
            throw new NotFoundException(__('Invalid planificacione'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Planificacione->save($this->request->data)) {
                $this->Session->setFlash(__('The planificacione has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The planificacione could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Planificacione.' . $this->Planificacione->primaryKey => $id));
            $this->request->data = $this->Planificacione->find('first', $options);
        }
        $carteras = $this->Planificacione->Cartera->find('list');
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
        $this->Planificacione->id = $id;
        if (!$this->Planificacione->exists()) {
            throw new NotFoundException(__('Invalid planificacione'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Planificacione->delete()) {
            $this->Session->setFlash(__('La planificacion de gestion ha sido borrada.'), 'flash_ok');
        } else {
            $this->Session->setFlash(__('No se puede borrar la planificacion de gestion!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        }
        return $this->redirect(array('action' => 'index'));
    }

}
