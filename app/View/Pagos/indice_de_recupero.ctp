<?php
/*
 * Muestro el indice de recupero diario, semanal y mensual en general y en particular po cada indicador de recupero definido
 * (para una cartera y comparativo).
 */

echo "
    <script type=\"text/javascript\">

        $(document).ready(function() {
            $('.tablaInforme').dataTable({
                'bJQueryUI': true,
                'bPaginate': true,
                'bLengthChange': true,
                'bFilter': true,
                'bSort': true,
//                'bInfo': true,
                'bAutoWidth': false,
//                'sPaginationType': 'full_numbers',
                'oLanguage': {
                                'sUrl': '../de_ES.txt'
                             }
            }
            );        
        });
    </script>
";

if (!empty($datos)) {    
    /* 
     * Formateo los datos a la forma de mas facil manipulacion para mostrar.
     */
    $pagos = $pagosEI = $detallePagos = array();
    
    foreach ($datos as $dato) {
        if (!key_exists('Pago', $dato)) {
            echo sprintf("
                <script type='text/javascript'>
                    $('#informe').hide();
                    $(location).attr('href', '%s/devel/satod/pagos/generarInformeDeRecupero');
                    $('#informe').dialog('destroy');
                </script>
            ", FULL_BASE_URL);
        }
        foreach ($dato['Pago'] as $pago) {
            $fecha = fecha($pago['fecha']);        
            @$pagos[$pago['Cartera']['id']][getTimestamp($pago['fecha'])] += $pago['monto'];
            @$pagosXmes[$pago['Cartera']['id']][substr($fecha, 3, 2)] += $pago['monto'];
            @$comisiones[$pago['Cartera']['id']][getTimestamp($pago['fecha'])] += $pago['comision'];
            @$comisionesXMes[$pago['Cartera']['id']][substr($fecha, 3, 2)] += $pago['comision'];

            if (substr($fecha, 0, 2) >= 1 && substr($fecha, 0, 2) <= 7) {
                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][0][] = $pago;
            } else if (substr($fecha, 0, 2) >= 8 && substr($fecha, 0, 2) <= 14) {
                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][1][] = $pago;
            } else if (substr($fecha, 0, 2) >= 15 && substr($fecha, 0, 2) <= 21) {
                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][2][] = $pago;
            } else if (substr($fecha, 0, 2) >= 22 && substr($fecha, 0, 2) <= 31) {
                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][3][] = $pago;
            }
        }
    }
    
    /*
     * Me fijo el importe de pagos y la comision por cada detalle de planificacion, 
     * para saber cuanto corresponde a cada estrategia de gestion / indicador de recupero definidos.
     */        
    foreach ($detallesPlanificaciones as $detallePlanificaciones) {
        foreach ($datos as $dato) {
            foreach ($dato['Pago'] as $pago) {

                if ($pago['fecha'] >= $detallePlanificaciones['DetallesPlanificacione']['fecha_inicio'] && $pago['fecha'] <= $detallePlanificaciones['DetallesPlanificacione']['fecha_fin']) {

                    @$montoTotalEI += $pago['monto'];
                    @$comisionTotalEI += $pago['comision'];
    //                $planificacionesId[] = $detallePlanificaciones['DetallesPlanificacione']['id'];
    //                $detallePagos[$pago['fecha']][$detallePlanificaciones['DetallesPlanificacione']['id']] = $pago['monto'];
                    $pagosEI[$pago['Cartera']['id']][$detallePlanificaciones['DetallesPlanificacione']['id']] = array(
                        'importe' => $montoTotalEI,
                        'comision' => $comisionTotalEI,
                        'incidencia' => @($montoTotalEI/(array_sum($pagos[$pago['Cartera']['id']]))*100),
                        'estrategia' => $detallePlanificaciones['Estrategia']['nombre'],
                        'indicador' => $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']],
                        'fecha' => sprintf('%s / %s', fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_inicio']), fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_fin'])),
    //                    'cantidadPagosEI' => $cantidadPagosEI,
    //    //                                    'detallePagos' => $detallePagos,
                        'etiqueta' => sprintf("'%s - %s'", $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']], $detallePlanificaciones['Estrategia']['nombre']
                        ),
                    );
                }
            }
            @$montoTotalEI = 0;
            @$comisionTotalEI = 0;            
        }
    }


    // Sumarizo los pagos por dia y monto; y por dia y cantidad; y le doy formato adecuado a la fecha.    
    // Tambien sumarizo por importe y cantidad por Detalle de planificacion
        
    // Armo el encabezado del informe
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos[0]['Cliente']['nombre']));       
                                            
    /** 
     * Muestro el recupero (suma de monto y porcentaje de incidencia) realizados por dia,
     * se puede seleccionar una sola cartera o puede ser comparativo de una a n carteras.
     * 
     */        
    $htmlRecuperoDiario = array();
       
    $graficaRecuperoDiario = null;
    $graficaRecuperoDiario['options']['title'] = 'Indice de Recupero Diario';
    $graficaRecuperoDiario['divContenedor'] = sprintf('grafica_indice_de_recupero_diario');
    $graficaRecuperoDiario['options']['hAxis']['title'] = 'Dia';
    $graficaRecuperoDiario['options']['vAxis']['title'] = 'Importe';
    
    if (count($pagos) == 1) {
        $graficaRecuperoDiario['tipoGrafica'] = 'ColumnChart';
        $graficaRecuperoDiario['items'][] = array(
            "'Dia'",
            "'Recupero'",
            "'Comision'",
        );
        $htmlEncabezado['cartera'] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));
    } else if (count($pagos) > 1) {
        $graficaRecuperoDiario['tipoGrafica'] = 'LineChart';
        $items = explode(",", sprintf("'%s'", implode("', '", $carteras)));        
        array_unshift($items, "'Dia'");       
        $graficaRecuperoDiario['items'][] = $items;        
    }
    
    foreach ($pagos as $cartera_id => $pago) {
        ksort($pago);
        
        $tablaRecuperoDiarioXCartera = null;
        if (count($pagos) > 1) {
            $tablaRecuperoDiarioXCartera[] = $this->Html->tag('h3', sprintf('%s', $carteras[$cartera_id]));
        }        
        $tablaRecuperoDiarioXCartera[] = $this->Html->tag('thead', $this->Html->tableHeaders(array('Fecha', 'Importe', 'Comision', '% de Incidencia')));   
        foreach ($pago as $fecha => $monto) {            
            $tablaRecuperoDiarioXCartera[] = $this->Html->tableCells(array(
                    array(
                            fechaFromTimestamp($fecha),
                            nro($monto),
                            nro($comisiones[$cartera_id][$fecha]),
                            sprintf("%s %%", nro(($monto/(array_sum($pagos[$cartera_id]))*100))),
                        )
            ));

            $pagosIncidencia[$cartera_id][] = (($monto/(array_sum($pagos[$cartera_id])))*100);
            
            if (count($pagos) == 1) {
                $graficaRecuperoDiario['items'][] = array(
                    sprintf('"%s"', substr(fechaFromTimestamp($fecha), 0, 5)),
                    $monto,
                    $comisiones[$cartera_id][$fecha],
                );
            } else {
                $pagosXfechaXcartera[$fecha][$cartera_id][] = $monto;
            }

        }
        $tablaRecuperoDiarioXCartera[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(  
                                                                        'TOTAL',
                                                                        nro(array_sum($pagos[$cartera_id])),
                                                                        nro(array_sum($comisiones[$cartera_id])),
                                                                        sprintf("%s %%", nro(array_sum($pagosIncidencia[$cartera_id]))), 
                                                                                        )
        )));
        $tablaRecuperoDiario[] = $this->Html->tag('table', implode("\n", $tablaRecuperoDiarioXCartera), array('class' => 'tablaInforme'));
    }
    
    if (!empty($pagosXfechaXcartera)) {
        foreach ($pagosXfechaXcartera as $fecha => $carteraMonto) {        
            $item = null;
            $item[] = sprintf('"%s"', substr(fechaFromTimestamp($fecha), 0, 5));
            foreach ($carteras as $cartera_id => $x) { 
                if (array_key_exists($cartera_id, $carteraMonto)) {
                  $item[] = $carteraMonto[$cartera_id][0];  
                } else {
                  $item[] = 0;  
                }            
            }
            array_push($graficaRecuperoDiario['items'], $item);
        }        
    }      
      
    $htmlRecuperoDiario[] = $this->Html->div('grafica', '', array('id' => 'grafica_indice_de_recupero_diario'));    
    $htmlRecuperoDiario[] = $this->Googlechart->paint($graficaRecuperoDiario);
    $htmlRecuperoDiario[] = implode("\n", $tablaRecuperoDiario);
    
    
                    
    /** 
     * Muestro el recupero realizado por semana
     * 
     */   
    $htmlRecuperoSemanal = array();
    
    $graficaRecuperoSemanal = null;
    $graficaRecuperoSemanal['options']['title'] = 'Indice de Recupero Semanal';
    $graficaRecuperoSemanal['divContenedor'] = sprintf('grafica_indice_de_recupero_semanal');    
    $graficaRecuperoSemanal['options']['hAxis']['title'] = 'Semana';
    $graficaRecuperoSemanal['options']['vAxis']['title'] = 'Importe';
    
    if (count($pagos) == 1) {
        $graficaRecuperoSemanal['tipoGrafica'] = 'ColumnChart';
        $graficaRecuperoSemanal['items'][] = array(
            "'Semana'",
            "'Recupero'",
            "'Comision'",
        );
        $htmlEncabezado['cartera'] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));
    } else if (count($pagos) > 1) {
        $graficaRecuperoSemanal['tipoGrafica'] = 'LineChart';
        $items = explode(",", sprintf("'%s'", implode("', '", $carteras)));        
        array_unshift($items, "'Semana'");       
        $graficaRecuperoSemanal['items'][] = $items;
    }
          
    foreach ($pagosSemanales as $cartera_id => $pagosSemanal) {
        $total = null;
        ksort($pagosSemanal);
        $tablaRecuperoSemanalXCartera = null;
        if (count($pagos) > 1) {
            $tablaRecuperoSemanalXCartera[] = $this->Html->tag('h3', sprintf('%s', $carteras[$cartera_id]));
        }  
        $tablaRecuperoSemanalXCartera[] = $this->Html->tag('thead', $this->Html->tableHeaders(array('Mes', 'Semana', 'Importe', 'Comision', '% de Incidencia')));        
        foreach ($pagosSemanal as $mes => $semanas) {
            foreach ($semanas as $semana => $pagosXSemana) {
                $tablaRecuperoSemanalXCartera[] = $this->Html->tableCells(array(
                        array(
                                getMes($mes),
                                $semana+1,
                                nro(array_sum(Set::extract($pagosXSemana, '{n}.monto'))),
                                nro(array_sum(Set::extract($pagosXSemana, '{n}.comision'))),
                                sprintf("%s %%", nro((array_sum(Set::extract($pagosXSemana, '{n}.monto'))/(array_sum($pagos[$cartera_id]))*100))),
                            )
                )); 
                
                if (count($pagos) == 1) {
                    $graficaRecuperoSemanal['items'][] = array(
                        sprintf("'%s / %s'", $semana+1, getMes($mes)),
                        array_sum(Set::extract($pagosXSemana, '{n}.monto')),
                        array_sum(Set::extract($pagosXSemana, '{n}.comision')),
                    );
                } else {
                    $pagosXsemanaXcartera[sprintf("'%s / %s'", $semana+1, getMes($mes))][$cartera_id][] = $monto;
                }                                                                                
                                                
                $total['semanas'][$mes] = count($semanas);
                $total['monto'][] = array_sum(Set::extract($pagosXSemana, '{n}.monto'));
                $total['comision'][] = array_sum(Set::extract($pagosXSemana, '{n}.comision'));
                $total['incidencia'][] = (array_sum(Set::extract($pagosXSemana, '{n}.monto'))/(array_sum($pagos[$cartera_id]))*100);
            }                           
        }
        $tablaRecuperoSemanalXCartera[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                                                                        'TOTAL',
                                                                        array_sum($total['semanas']),
                                                                        nro(array_sum($total['monto'])),
                                                                        nro(array_sum($total['comision'])),
                                                                        sprintf("%s %%", nro(array_sum($total['incidencia']))), 
                                                                                                )
        )));
        $tablaRecuperoSemanal[] = $this->Html->tag('table', implode("\n", $tablaRecuperoSemanalXCartera), array('class' => 'tablaInforme'));
        
    }
    
    if (!empty($pagosXsemanaXcartera)) {
        foreach ($pagosXsemanaXcartera as $semana => $carteraMonto) {        
            $item = null;
            $item[] = $semana;
            foreach ($carteras as $cartera_id => $x) { 
                if (array_key_exists($cartera_id, $carteraMonto)) {
                  $item[] = $carteraMonto[$cartera_id][0];  
                } else {
                  $item[] = 0;  
                }            
            }
            array_push($graficaRecuperoSemanal['items'], $item);
        }        
    }      
                                  
    $htmlRecuperoSemanal[] = $this->Html->div('grafica', '', array('id' => 'grafica_indice_de_recupero_semanal'));
    $htmlRecuperoSemanal[] = $this->Googlechart->paint($graficaRecuperoSemanal);
    $htmlRecuperoSemanal[] = implode("\n", $tablaRecuperoSemanal);
    
    
    /** 
     * Muestro el recupero realizado por mes
     * 
     */        
    $htmlRecuperoMensual = array();                    
    
    $graficaRecuperoMensual = null;
    $graficaRecuperoMensual['options']['title'] = 'Indice de Recupero mensual';
    $graficaRecuperoMensual['divContenedor'] = sprintf('grafica_indice_de_recupero_mensual');    
    $graficaRecuperoMensual['options']['hAxis']['title'] = 'Mes';
    $graficaRecuperoMensual['options']['vAxis']['title'] = 'Importe';
   
    if (count($pagos) == 1) {
        $graficaRecuperoMensual['tipoGrafica'] = 'ColumnChart';
        $graficaRecuperoMensual['items'][] = array(
            "'Mes'",
            "'Recupero'",
            "'Comision'",
        );
        $htmlEncabezado['cartera'] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));
    } else if (count($pagos) > 1) {
        $graficaRecuperoMensual['tipoGrafica'] = 'LineChart';
        $items = explode(",", sprintf("'%s'", implode("', '", $carteras)));        
        array_unshift($items, "'Mes'");       
        $graficaRecuperoMensual['items'][] = $items;
    }
        
    foreach ($pagosXmes as $cartera_id => $pagoXmes) {
        ksort($pagoXmes);
        $tablaRecuperoMensualXcartera = null;
        if (count($pagos) > 1) {
            $tablaRecuperoMensualXcartera[] = $this->Html->tag('h3', sprintf('%s', $carteras[$cartera_id]));
        }  
        $tablaRecuperoMensualXcartera[] = $this->Html->tag('thead', $this->Html->tableHeaders(array('Mes', 'Importe', 'Comision', '% de Incidencia')));
        foreach ($pagoXmes as $mes => $importe) {
            $tablaRecuperoMensualXcartera[] = $this->Html->tableCells(array(
                    array(
                            getMes($mes),
                            nro($importe),
                            nro($comisionesXMes[$cartera_id][$mes]),
                            sprintf("%s %%", nro(($importe/(array_sum($pagos[$cartera_id]))*100))),
                        )
            ));
            
            if (count($pagos) == 1) {
                $graficaRecuperoMensual['items'][] = array(
                    sprintf('"%s"', getMes($mes)),
                    $importe,
                    $comisionesXMes[$cartera_id][$mes],
                );
            } else {
                $pagosXmesXcartera[sprintf("'%s'", getMes($mes))][$cartera_id][] = $monto;
            }  

        }
        $tablaRecuperoMensualXcartera[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(  
                                                                'TOTAL',
                                                                nro(array_sum($pagos[$cartera_id])),
                                                                nro(array_sum($comisiones[$cartera_id])),
                                                                sprintf("%s %%", nro(array_sum($pagosIncidencia))), 
                                                                                )
        )));
        $tablaRecuperoMensual[] = $this->Html->tag('table', implode("\n", $tablaRecuperoMensualXcartera), array('class' => 'tablaInforme'));
    }
    
    if (!empty($pagosXmesXcartera)) {
        foreach ($pagosXmesXcartera as $mes => $carteraMonto) {        
            $item = null;
            $item[] = $mes;
            foreach ($carteras as $cartera_id => $x) { 
                if (array_key_exists($cartera_id, $carteraMonto)) {
                  $item[] = $carteraMonto[$cartera_id][0];  
                } else {
                  $item[] = 0;  
                }            
            }
            array_push($graficaRecuperoMensual['items'], $item);
        }        
    }
    
    $htmlRecuperoMensual[] = $this->Html->div('grafica', '', array('id' => 'grafica_indice_de_recupero_mensual'));       
    $htmlRecuperoMensual[] = $this->Googlechart->paint($graficaRecuperoMensual);
    $htmlRecuperoMensual[] = implode("\n", $tablaRecuperoMensual);
    
    
    /** 
     * Muestro el indice de recupero de acuerdo a las estrategias de gestion - indicadores de recupero planificados 
     * (para cada detalle de planificacion realizado) hay que ver la cantidad de dias a tomar como regla de negocio!!!!!!!!!!   
     */           
    $htmlRecuperoEI = array();
    
    $htmlRecuperoEI[] = $this->Html->div('grafica', '', array('id' => 'grafica_indice_de_recupero_comision_EI'));
    $graficaIndiceRecuperoXEI = null;
    $graficaIndiceRecuperoXEI['options']['title'] = 'Indice de recupero por Indicadores de recupero / Estrategias de Gestion';
    $graficaIndiceRecuperoXEI['divContenedor'] = sprintf('grafica_indice_de_recupero_comision_EI');    
    
        
    if (count($pagos) == 1) {
        $graficaIndiceRecuperoXEI['tipoGrafica'] = 'BarChart';
        $graficaIndiceRecuperoXEI['items'][] = array("'Indicador / Estrategia'", "'Recupero'", "'Comision'");
        $graficaIndiceRecuperoXEI['options']['hAxis']['titulo'] = 'Importe';
        $graficaIndiceRecuperoXEI['options']['vAxis']['titulo'] = 'Indicador / Estrategia';
        $htmlEncabezado['cartera'] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));
    } else if (count($pagos) > 1) {
        $graficaIndiceRecuperoXEI['tipoGrafica'] = 'LineChart';
        $items = explode(",", sprintf("'%s'", implode("', '", $carteras)));        
        array_unshift($items, "'Indicador / Estrategia'");
        $graficaIndiceRecuperoXEI['items'][] = $items;
        $graficaIndiceRecuperoXEI['options']['vAxis']['title'] = 'Importe';
        $graficaIndiceRecuperoXEI['options']['hAxis']['title'] = 'Indicador / Estrategia';
    }            
    
    foreach ($pagosEI as $cartera_id => $pagoEI) {
        $tablaRecuperoEIXcartera = null;
        if (count($pagos) > 1) {
            $tablaRecuperoEIXcartera[] = $this->Html->tag('h3', sprintf('%s', $carteras[$cartera_id]));
        } 
        $tablaRecuperoEIXcartera[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                                                                                'Indicador de recupero', 
                                                                                'Estrategia de gestion', 
                                                                                'Fecha', 
                                                                                'Importe',
                                                                                'Comision',
                                                                                '% de Incidencia',
                                                                                )
                                                                            ));
        foreach ($pagoEI as $pago) {
            $tablaRecuperoEIXcartera[] = $this->Html->tableCells(array(array(
                    $pago['indicador'],
                    $pago['estrategia'],
                    $pago['fecha'],
                    nro($pago['importe']),
                    nro($pago['comision']),
                    sprintf('%s %%', nro($pago['incidencia'])),
                )
            ));

            if (count($pagos) == 1) {
                $graficaIndiceRecuperoXEI['items'][] = array(
                    sprintf("'%s / %s'", $pago['indicador'], $pago['estrategia']),
                    $pago['importe'],
                    $pago['comision'],
                );
            } else {
                $pagosXIEXcartera[sprintf("'%s / %s'", $pago['indicador'], $pago['estrategia'])][$cartera_id][] = $pago['importe'];
            }

        }
        $tablaRecuperoEIXcartera[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                '',
                '',
                'TOTAL',
                nro(array_sum(Set::extract($pagoEI, '{n}.importe'))),
                nro(array_sum(Set::extract($pagoEI, '{n}.comision'))),
                sprintf('%s %%', nro(array_sum(Set::extract($pagoEI, '{n}.incidencia')))),
            )
        )));
        $tablaRecuperoEI[] = $this->Html->tag('table', implode("\n", $tablaRecuperoEIXcartera), array('class' => 'tablaInforme'));
    }
    
    if (!empty($pagosXIEXcartera)) {
        foreach ($pagosXIEXcartera as $IE => $carteraMonto) {        
            $item = null;
            $item[] = $IE;
            foreach ($carteras as $cartera_id => $x) { 
                if (array_key_exists($cartera_id, $carteraMonto)) {
                  $item[] = $carteraMonto[$cartera_id][0];  
                } else {
                  $item[] = 0;  
                }            
            }
            array_push($graficaIndiceRecuperoXEI['items'], $item);
        }        
    }
    
    $htmlRecuperoEI[] = $this->Googlechart->paint($graficaIndiceRecuperoXEI);
    $htmlRecuperoEI[] = implode("\n", $tablaRecuperoEI);
                                               
    
    /** 
     * Muestro todo en el html del informe.
     * 
     */
    $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" >';
    $html[] = '<legend> Informe de Indice de Recupero</legend>';
    
    $html[] = $this->Html->div('encabezado', implode("\n", array_unique($htmlEncabezado)));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoDiario));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoSemanal));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoMensual));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoEI));

    $html[] = '</fieldset>';
    echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));              
}

?>
