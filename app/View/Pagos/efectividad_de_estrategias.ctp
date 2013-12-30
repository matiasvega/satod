<?php
/*
 * 
 * Me fijo la cantidad de pagos y el monto recuperado durante la duracion +/- x dias de la estrategia de gestion planificado 
 * para la asignacion 
 * 
 * Posibilidad de hacerlo comparativo con  otras carteras del mismo cliente, lo cual va a significar comparar distintos 
 * periodos de tiempo
 *  
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
                    $(location).attr('href', '%s/satod/pagos/generarEfectividadEstrategias');
                    $('#informe').dialog('destroy');
                    
                </script>
            ", FULL_BASE_URL);
        }
//        dd($dato);
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos[0]['Cliente']['nombre']));
//        dd('xxxx');
        foreach ($dato['Pago'] as $pago) {
//            dd($pago);
//            $fecha = fecha($pago['fecha']);        
            @$pagos[$pago['Cartera']['id']][getTimestamp($pago['fecha'])] += $pago['monto'];
//            @$pagosXmes[$pago['Cartera']['id']][substr($fecha, 3, 2)] += $pago['monto'];
            @$comisiones[$pago['Cartera']['id']][getTimestamp($pago['fecha'])] += $pago['comision'];
//            @$comisionesXMes[$pago['Cartera']['id']][substr($fecha, 3, 2)] += $pago['comision'];

//            if (substr($fecha, 0, 2) >= 1 && substr($fecha, 0, 2) <= 7) {
//                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][0][] = $pago;
//            } else if (substr($fecha, 0, 2) >= 8 && substr($fecha, 0, 2) <= 14) {
//                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][1][] = $pago;
//            } else if (substr($fecha, 0, 2) >= 15 && substr($fecha, 0, 2) <= 21) {
//                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][2][] = $pago;
//            } else if (substr($fecha, 0, 2) >= 22 && substr($fecha, 0, 2) <= 31) {
//                $pagosSemanales[$pago['Cartera']['id']][substr($fecha, 3, 2)][3][] = $pago;
//            }
        }
    }
    
    /*
     * Me fijo el importe de pagos y la comision por cada detalle de planificacion, 
     * para saber cuanto corresponde a cada estrategia de gestion / indicador de recupero definidos.
     */        
//    d($indicadores);
    foreach ($detallesPlanificaciones as $detallePlanificaciones) {
        foreach ($datos as $dato) {
            foreach ($dato['Pago'] as $pago) {
//                d($detallePlanificaciones);
//                dd($pago);
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
                        'indicador' => $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']]['IndicadoresValore']['valor'],
                        'importeARecuperar' => $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']]['IndicadoresValore']['valor_ponderado'],
                        'fecha' => sprintf('%s / %s', fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_inicio']), fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_fin'])),
    //                    'cantidadPagosEI' => $cantidadPagosEI,
    //    //                                    'detallePagos' => $detallePagos,
//                        'etiqueta' => sprintf("'%s - %s'", $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']], $detallePlanificaciones['Estrategia']['nombre']
                        'etiqueta' => sprintf("'%s'", $detallePlanificaciones['Estrategia']['nombre']
                        ),
                    );
                }
            }
            @$montoTotalEI = 0;
            @$comisionTotalEI = 0;            
        }
    }
            
//    dd($pagosEI);
          
    /** 
     * Muestro el indice de recupero de acuerdo a las estrategias de gestion - indicadores de recupero planificados 
     * (para cada detalle de planificacion realizado) hay que ver la cantidad de dias a tomar como regla de negocio!!!!!!!!!!   
     */           
    $htmlRecuperoEI = array();
    
    $htmlRecuperoEI[] = $this->Html->div('grafica', '', array('id' => 'grafica_indice_de_recupero_comision_EI'));
    $graficaIndiceRecuperoXEI = null;
    $graficaIndiceRecuperoXEI['options']['title'] = 'Efectividad de Estrategias de Gestion';
    $graficaIndiceRecuperoXEI['divContenedor'] = sprintf('grafica_indice_de_recupero_comision_EI');    
    
        
    if (count($pagos) == 1) {
        $graficaIndiceRecuperoXEI['tipoGrafica'] = 'ColumnChart';
        $graficaIndiceRecuperoXEI['items'][] = array("'Indicador / Estrategia'", "'% Efectividad'");
        $graficaIndiceRecuperoXEI['options']['hAxis']['titulo'] = '% Efectividad';
        $graficaIndiceRecuperoXEI['options']['vAxis']['titulo'] = 'Indicador / Estrategia';
        $htmlEncabezado['cartera'] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));
    } else if (count($pagos) > 1) {
        $graficaIndiceRecuperoXEI['tipoGrafica'] = 'LineChart';
        $items = explode(",", sprintf("'%s'", implode("', '", $carteras)));        
        array_unshift($items, "'Indicador / Estrategia'");
        $graficaIndiceRecuperoXEI['items'][] = $items;
        $graficaIndiceRecuperoXEI['options']['vAxis']['title'] = '% Efectividad';
        $graficaIndiceRecuperoXEI['options']['hAxis']['title'] = 'Indicador / Estrategia';
    }            
    
    foreach ($pagosEI as $cartera_id => $pagoEI) {
        $tablaRecuperoEIXcartera = null;
        if (count($pagos) > 1) {
            $tablaRecuperoEIXcartera[] = $this->Html->tag('h3', sprintf('%s', $carteras[$cartera_id]));
        } 
        $tablaRecuperoEIXcartera[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                                                                                'Estrategia de gestion', 
                                                                                'Indicador de recupero', 
                                                                                'Fecha', 
                                                                                'Importe Recuperado',
//                                                                                'Comision',
//                                                                                '% de Incidencia',
                                                                                'Importe a Recuperar',
                                                                                '% de Eficiencia',
                                                                                )
                                                                            ));
        foreach ($pagoEI as $pago) {
            $tablaRecuperoEIXcartera[] = $this->Html->tableCells(array(array(                    
                    $pago['estrategia'],
                    $pago['indicador'],
                    $pago['fecha'],
                    nro($pago['importe']),
//                    nro($pago['comision']),
//                    sprintf('%s %%', nro($pago['incidencia'])),
                    nro($pago['importeARecuperar']),
                    nro(($pago['importe']*100)/$pago['importeARecuperar']),
                )
            ));

            if (count($pagos) == 1) {
                $graficaIndiceRecuperoXEI['items'][] = array(
                    sprintf("'%s / %s'", $pago['indicador'], $pago['estrategia']),
                    (($pago['importe']*100)/$pago['importeARecuperar']),
                );
            } else {
                $pagosXIEXcartera[sprintf("'%s / %s'", $pago['indicador'], $pago['estrategia'])][$cartera_id][] = (($pago['importe']*100)/$pago['importeARecuperar']);
            }

        }
        $tablaRecuperoEIXcartera[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                '',
                '',
                'TOTAL',
                nro(array_sum(Set::extract($pagoEI, '{n}.importe'))),
//                nro(array_sum(Set::extract($pagoEI, '{n}.comision'))),
//                sprintf('%s %%', nro(array_sum(Set::extract($pagoEI, '{n}.incidencia')))),
                nro(array_sum(Set::extract($pagoEI, '{n}.importeARecuperar'))),
                nro((array_sum(Set::extract($pagoEI, '{n}.importe'))*100)/array_sum(Set::extract($pagoEI, '{n}.importeARecuperar'))),
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
    $html[] = '<legend> Informe de Efectividad de Estrategias de Gestion </legend>';
    

    
    $html[] = $this->Html->div('encabezado', implode("\n", array_unique($htmlEncabezado)));
//    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoDiario));
//    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoSemanal));
//    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoMensual));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlRecuperoEI));

    $html[] = '</fieldset>';
    echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));              
}

?>
