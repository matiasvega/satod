<?php

App::uses('AppController', 'Controller');

/**
 * Carteras Controller
 *
 * @property Cartera $Cartera
 * @property PaginatorComponent $Paginator
 */
class CarterasController extends AppController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator',
//                                'Upload'
            /* 'Session', 
              'AjaxMultiUpload.Upload' */
    );

    public $helpers = array(
                        'Googlechart',
//                        'PhpExcel'
                    );     
    
    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Cartera->recursive = 0;
        $this->set('carteras', $this->Paginator->paginate());
        $this->set('estados', array('P' => 'Potencial', 'A' => 'Asignada'));
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        if (!$this->Cartera->exists($id)) {
            throw new NotFoundException(__('Invalid cartera'));
        }
        $options = array('conditions' => array('Cartera.' . $this->Cartera->primaryKey => $id));
        $this->set('cartera', $this->Cartera->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {            
            // Guardo los indicadores de recupero particulares con sus indicadores_valores correspondientes 
            // (depende del tipo de calculo).
            $i = 0;
            foreach ($this->request->data['Cartera']['CalculoColumna'] as $k => $calculo) {
                if (!empty($calculo)) {                    
                    $indicadoresParticulares[$i]['Indicadore']['etiqueta'] = $this->request->data['Cartera']['EtiquetaColumna'][$k];
                    $indicadoresParticulares[$i]['Indicadore']['tipo'] = 'P';
                    $indicadoresParticulares[$i]['Indicadore']['calculo'] = $calculo;
                    if (!empty($this->request->data['Cartera']['GraficaColumna'][$k])) {
                       $indicadoresParticulares[$i]['Indicadore']['grafica'] = $this->request->data['Cartera']['GraficaColumna'][$k];
                    }                    

                    $resultadoCalculo = null;
                    if ($calculo == 'sum') {
                        $resultadoCalculo = $this->Cartera->query(sprintf("select sum(col%s) from tmp_cartera;", $this->request->data['Cartera']['Columna'][$k]));
                        $indicadoresParticulares[$i]['IndicadoresValore'][0]['valor'] = $calculo;
                        $indicadoresParticulares[$i]['IndicadoresValore'][0]['valor_ponderado'] = $resultadoCalculo[0][0][sprintf('sum(col%s)', $this->request->data['Cartera']['Columna'][$k])];
                    } else if ($calculo == 'avg') {
                        $resultadoCalculo = $this->Cartera->query(sprintf("select avg(col%s) from tmp_cartera;", $this->request->data['Cartera']['Columna'][$k]));
                        $indicadoresParticulares[$i]['IndicadoresValore'][0]['valor'] = $calculo;
                        $indicadoresParticulares[$i]['IndicadoresValore'][0]['valor_ponderado'] = $resultadoCalculo[0][0][sprintf('avg(col%s)', $this->request->data['Cartera']['Columna'][$k])];
                    } else if ($calculo == 'group') {
//                        d(sprintf("select col%s as valor, sum(col%s) as valor_ponderado from x group by col%s having sum(col%s) > 0;", $this->request->data['Cartera']['Columna'][$k], $this->request->data['Cartera']['totalDeuda'], $this->request->data['Cartera']['Columna'][$k], $this->request->data['Cartera']['totalDeuda']));
                        
                        $resultadoCalculo = $this->Cartera->query(sprintf("select col%s as valor, sum(col%s) as valor_ponderado from tmp_cartera group by col%s having sum(col%s) > 0;", 
                                $this->request->data['Cartera']['Columna'][$k], 
                                $this->request->data['Cartera']['totalDeuda'], 
                                $this->request->data['Cartera']['Columna'][$k],
                                $this->request->data['Cartera']['totalDeuda']
                                                                         )
                                                                );
                        $valores = Set::extract('{n}/tmp_cartera/valor', $resultadoCalculo);
                        $valores_ponderados = Set::extract('{n}/0/valor_ponderado', $resultadoCalculo);

                        foreach ($resultadoCalculo as $k => $resultado) {
                            $indicadoresParticulares[$i]['IndicadoresValore'][$k]['valor'] = (!empty($valores[$k])) ? $valores[$k] : '-';
                            $indicadoresParticulares[$i]['IndicadoresValore'][$k]['valor_ponderado'] = $valores_ponderados[$k];
                        }
                    }
                    $i++;
                }
            }

            foreach ($indicadoresParticulares as $indicadorParticular) {
                ClassRegistry::init('Indicadore')->saveAll($indicadorParticular);
                $newIndicadoresId[] = ClassRegistry::init('Indicadore')->getLastInsertId();
            }

            // Guardo la  cartera de deudores, con los indicadores de recupero definidos para ella.
            $data['Cartera'] = array(
                'nombre' => $this->request->data['Cartera']['nombre'],
                'clientes_id' => $this->request->data['Cartera']['clientes_id'],
                'estado' => $this->request->data['Cartera']['estado'],
                'comision' => $this->request->data['Cartera']['comision'],
            );

            foreach ($newIndicadoresId as $newIndicadorId) {
                $data['Indicadore'][] = array('indicadores_id' => $newIndicadorId);
            }

            // Guardo el valor seleccionado de los indicadores generales de recupero
            foreach ($this->request->data['Cartera']['Indicadores'] as $idIndicadorGeneral => $idIndicadorValorGeneral) {
                $data['Indicadore'][] = array('indicadores_id' => $idIndicadorGeneral,
                    'indicadores_valores_id' => $idIndicadorValorGeneral,);
            }

            $this->request->data = $data;
            $this->Cartera->create();
            if ($this->Cartera->saveAll($this->request->data)) {
                $this->Session->setFlash(__('La cartera de deudores ha sido guardada.'), 'flash_ok');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
            }
        }       
        
        $clientes = $this->Cartera->Cliente->find('list');
        if (!empty($clientes)) {
            $this->set(compact('clientes'));
        } else {
            $this->Session->setFlash(__('No se encontraron clientes registrados. Para poder registrar una cartera, se requiere que existan registrados clientes.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        }
        
        /* Busco los indicadores generales, para hacerlos disponibles para su seleccion en la vista */
        $indicadores = ClassRegistry::init('Indicadore')->find('all', array('conditions' => array('tipo' => 'G')));                
        if (!empty($indicadores)) {
            foreach ($indicadores as $k => $indicador) {
                foreach ($indicador['IndicadoresValore'] as $valores) {
                    $indicadoresGenerales['indicadores'][$indicador['Indicadore']['etiqueta']]['id'] = $indicador['Indicadore']['id'];
                    $indicadoresGenerales['indicadores'][$indicador['Indicadore']['etiqueta']]['valores'][$valores['id']] = $valores['valor'];
                }
            }
            $this->set('indicadoresGenerales', $indicadoresGenerales);
        } else {
            $this->Session->setFlash(__('No se encontraron indicadores de recupero registrados. Para poder registrar una cartera, se requiere que existan registrados indicadores generales de recupero.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        }
        
    }

    // Se usa para la importacion de una cartera de deudores. (sube al servidor el archivo en conjunto con importarCartera)
    public function cargar($flag = false) {
        if ($this->request->is('post') || $flag) {
            $upload = $this->Components->load('Upload');
            $upload->initializeI();
            $this->render('columnasCartera');
        }
    }

    public function columnasCartera() {
        
    }
    
    public function importarCartera() {
        /* Cargo la cartera de deudores, y muestro sus campos a fin de que el usuario pueda 
         * definir indicadores de recupero particulares */
        // MUEVO EL ARCHIVO A UNA LOCALIZACION DENTRO DEL SERVIDOR

        $archivo = WWW_ROOT . DS . 'files' . DS . $this->request->data['files'][0]['name'];
        // Obtengo las columnas del archivo csv, con el objetivo de mostrarlas 
        // al usuario y que pueda definir indicadores particulares
        if (($gestor = fopen($archivo, "r")) !== FALSE) {
            $columnas = fgetcsv($gestor, 2000, ";");
            fclose($gestor);
            // Cargo la cartera en una tabla temporal de la db, para analizar sus datos y
            //  poder definir indicadores particulares.
            $this->Cartera->query("truncate table tmp_cartera;");
            $this->Cartera->query(sprintf("load data infile '%s' into table tmp_cartera fields terminated by ';';", $archivo));
        } else {
            $this->Session->setFlash(__('No se pueden importar los datos de la cartera en estos momentos. Si ersiste el error couniquese con el administrador del sistema.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        }
        $this->set('columnas', $columnas);
    }

    public function analizar($id_estrategiasPDF = false, $idCarteraPDF = false) {
                
        if ($this->request->is('post')) {     
            
            if (key_exists('Planificacione', $this->request->data)) {
                $carteras_id = $this->request->data['Planificacione']['carteras_id'];
            } else {
                $carteras_id = $this->request->data['Cartera']['carteras_id'];
                
                $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array(
                    'conditions' => array(
                        'Estrategia.id' => $this->request->data['Estrategia']['estrategias_id']
                    )
                        )
                );                
                $this->set('costosEstrategias', $costosEstrategias);
            }
            
            $datos = $this->Cartera->find('first', array(
                'conditions' => array(
                    'Cartera.id' => $carteras_id,
                ),
                'recursive' => 2
                    )
            );
            $this->set('datos', $datos);
            
//            $this->set(compact('datos', 'costosEstrategias'));
            $this->render('informe');
        }

        $estrategias = ClassRegistry::init('Estrategia')->find('list');
        $carteras = $this->Cartera->find('list');
        $clientes = $this->Cartera->Cliente->find('list');
                        
        if (empty($clientes)){
            $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else if (empty($carteras)) {
            $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else if (empty($estrategias)) {
            $this->Session->setFlash(__('No se encontraron datos de estrategias de gestion registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->set(compact('clientes', 'carteras', 'estrategias'));
        }
        

        if ($idCarteraPDF) {
            $datos = $this->Cartera->find('first', array('conditions' => array('Cartera.id' => $idCarteraPDF,
                ),
                'recursive' => 2)
            );

            $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array('conditions' => array('Estrategia.id' => explode(',', $id_estrategiasPDF)))
            );

            $this->pdfConfig = array(
                'orientation' => 'portrait',
                'download' => true,
                'filename' => sprintf('Cartera_%s_%s.pdf', str_replace(' ', '_', $datos['Cartera']['nombre']), str_replace(' ', '_', $datos['Cliente']['nombre'])
                ),
            );

            $this->set(compact('datos', 'costosEstrategias'));
            $this->render('informe');
        }               
        
    }
    
    public function analizarToExcel($id_estrategias = false, $idCartera = false){
        $this->layout = 'ajax';
        $datos = $this->Cartera->find('first', array('conditions' => array( 
                                                                                'Cartera.id' => $idCartera,
                                                                            ),
                                                     'recursive' => 2
                                                    )
            );

        $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array('conditions' => array(
                                                                'Estrategia.id' => explode(',', $id_estrategias)
                                                                                                        )
                                                                                 )
        );
        
        $this->set(compact('datos', 'costosEstrategias'));
        
    }
    
    public function createChart($idCartera, $id_estrategias = false) {
        $this->layout = 'ajax';
        $datos = $this->Cartera->find('first', array('conditions' => array( 
                                                                                'Cartera.id' => $idCartera,
                                                                            ),
                                                     'recursive' => 2
                                                    )
            );

        $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array('conditions' => array(
                                                                'Estrategia.id' => explode(',', $id_estrategias)
                                                                                                        )
                                                                                 )
        );
        
        $this->set(compact('datos', 'costosEstrategias'));
    }
    

    public function informe() {
        //pr($datos);
        //die;
        /*
          $this->pdfConfig = array(
          'orientation' => 'landscape',
          'download' => false,
          'filename' => 'Cartera.pdf'
          );
         */
        //$datos = 'xxxxx';
        //$this->set('datos', $datos);        
    }
        
    public function presupuestar($id_estrategiasPDF = false, $idCarteraPDF = false) {

        if ($this->request->is('post')) {
            $datos = $this->Cartera->find('first', array(
                'conditions' => array(
                    'Cartera.id' => $this->request->data['Cartera']['carteras_id'],
                ),
                'recursive' => 2
                    )
            );

            $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array(
                'conditions' => array(
                    'Estrategia.id' => $this->request->data['Estrategia']['estrategias_id']
                )
                    )
            );

            $this->set(compact('datos', 'costosEstrategias'));
            
            $this->render('presupuesto');
        }

        $estrategias = ClassRegistry::init('Estrategia')->find('list');
        $carteras = $this->Cartera->find('list');
        $clientes = $this->Cartera->Cliente->find('list');
                        
        if (empty($clientes)){
            $this->Session->setFlash(__('No se encontraron datos de clientes registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else if (empty($carteras)) {
            $this->Session->setFlash(__('No se encontraron datos de carteras de deudores registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else if (empty($estrategias)) {
            $this->Session->setFlash(__('No se encontraron datos de estrategias de gestion registrados.'), 'flash_error');
            return $this->redirect(array('action' => 'index'));
        } else {
            $this->set(compact('clientes', 'carteras', 'estrategias'));
        }
                
        
        if ($idCarteraPDF) {
            $datos = $this->Cartera->find('first', array('conditions' => array('Cartera.id' => $idCarteraPDF,
                ),
                'recursive' => 2)
            );
            
            $costosEstrategias = ClassRegistry::init('Estrategia')->find('all', array('conditions' => array('Estrategia.id' => explode(',', $id_estrategiasPDF)))
            );

            $this->pdfConfig = array(
                'orientation' => 'portrait',
                'download' => true,
                'filename' => sprintf('Cartera_%s_%s.pdf', str_replace(' ', '_', $datos['Cartera']['nombre']), str_replace(' ', '_', $datos['Cliente']['nombre'])
                ),
            );

            $this->set(compact('datos', 'costosEstrategias'));            
            $this->render('presupuesto');
        }
    }
    
    public function presupuesto() {

    }
    

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        if (!$this->Cartera->exists($id)) {
            throw new NotFoundException(__('Invalid cartera'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Cartera->save($this->request->data)) {
                $this->Session->setFlash(__('La cartera de deudores ha sido guardada.'), 'flash_ok');
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Los datos no se guardaron. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
            }
        } else {
            $options = array('conditions' => array('Cartera.' . $this->Cartera->primaryKey => $id));
            $this->request->data = $this->Cartera->find('first', $options);
        }
        $clientes = $this->Cartera->Cliente->find('list');
        $indicadores = $this->Cartera->Indicadore->find('list');
        
        $this->set(compact('clientes', 'indicadores'));
        $this->set('estados', array('P' => 'Potencial', 'A' => 'Asignada'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        $this->Cartera->id = $id;
        if (!$this->Cartera->exists()) {
            throw new NotFoundException(__('Invalid cartera'));
        }
        $this->request->onlyAllow('post', 'delete');
        if ($this->Cartera->delete()) {
            $this->Session->setFlash(__('La cartera de deudores ha sido borrada.'), 'flash_ok');
        } else {
            $this->Session->setFlash(__('No se puede borrar la cartera de deudores!. Si el error persiste notifique al administrador del sistema.'), 'flash_error');
        }
        return $this->redirect(array('action' => 'index'));
    }
    
    public function addPlanificacion() {
        return $this->redirect('/planificaciones/add');
    }
    
    public function indexPlanificaciones() {
        return $this->redirect('/planificaciones/');
    }
    
    public function getCarteras($idCliente) {        
        if (!empty($idCliente)) {
            $carteras = ClassRegistry::init('Cartera')->find('all', array(
                                                                        'conditions' => array(
                                                                                'Cartera.clientes_id' => $idCliente,
                                                                                            ),
                                                                         'recursive' => 0,
                                                                            )
                                                            );                    
    //                dd($carteras);
    //                dd(Set::extract('{n}.Cartera', $carteras));
            $carteras = json_encode(Set::extract('{n}.Cartera', $carteras));
            $this->set('carteras', $carteras);
        }        
    }
    
    
    

}
