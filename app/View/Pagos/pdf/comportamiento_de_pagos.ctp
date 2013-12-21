<?php

echo sprintf('
    <html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
                <title>
                        V/N Sistema de apoyo a la toma de decisiones: Planificaciones	
                </title>
                <script src="https://www.google.com/jsapi"></script>
                
                <link rel="stylesheet" type="text/css" href="http://localhost/devel/satod/css/cake.generic.css" />

        
        </head>
        <body>

            <div id="headerpdf">
                <div id="logo"> <img src="http://localhost/devel/satod/img/logo-vn-trans.png" /> </div>
                <div id="texto"> Business Process Outsourcing </div>
            </div>
            
            <div id="clearpdf"> </div>
');

if (isset($datos)) {
    // Verifico que para la cartera seleccionada existan pagos registrados.
    if (!key_exists('Pago', $datos[0])) {
        echo sprintf("
            <script type='text/javascript'>
                $('#informe').hide();
                $(location).attr('href', '%s/devel/satod/pagos/generarInformeDePagos');
                $('#informe').dialog('destroy');
            </script>
        ", FULL_BASE_URL);
    }
    
    // Muestro el encabezado
    $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" >';
    $html[] = '<legend> Informe de Comportamiento de Pagos</legend>';

    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos[0]['Cliente']['nombre']));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos[0]['Cartera']['nombre']));

    $html[] = $this->Html->div('encabezado', implode("\n", $htmlEncabezado));

    /*
     * Sumarizo los pagos por dia y monto; y por dia y cantidad; y le doy formato adecuado a la fecha.    
     * Tambien sumarizo por importe y cantidad por Detalle de planificacion
     */

    $pagos = $pagosEI = $detallePagos = array();
    
    foreach ($datos[0]['Pago'] as $pago) {
            $fecha = fecha($pago['fecha']);
            @$pagos[$fecha] += $pago['monto'];
            @$pagosCantidad[$fecha][] = $pago['monto'];
    }            
    
    foreach ($detallesPlanificaciones as $detallePlanificaciones) {
        $cantidadPagosEI = 0;        
        foreach ($datos[0]['Pago'] as $pago) {
//            $fecha = explode('-', $pago['fecha']);
//            @$fecha = date('d-m-Y', mktime(0, 0, 0, $fecha[1], $fecha[2], $fecha[0]));
//            @$pagos[$fecha] += $pago['monto'];
//            @$pagosCantidad[$fecha][] = $pago['monto'];

            // Me fijo la cantidad de pagos y el importe de los mismos por cada detalle de planificacion, 
            // para saber cuanto corresponde a cada estrategia de gestion / indicador de recupero definidos.

            $cantidadPagosFechaEI = 0;
            if ($pago['fecha'] >= $detallePlanificaciones['DetallesPlanificacione']['fecha_inicio'] && $pago['fecha'] <= $detallePlanificaciones['DetallesPlanificacione']['fecha_fin']) {
                $cantidadPagosEI++;
//                $cantidadPagosFechaEI++;
                @$montoTotalEI += $pago['monto'];

                $planificacionesId[] = $detallePlanificaciones['DetallesPlanificacione']['id'];

                $detallePagos[$pago['fecha']][$detallePlanificaciones['DetallesPlanificacione']['id']] = $pago['monto'];

                $pagosEI[$detallePlanificaciones['DetallesPlanificacione']['id']] = array(
                    'importe' => $montoTotalEI,
                    'estrategia' => $detallePlanificaciones['Estrategia']['nombre'],
                    'indicador' => $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']],
                    'fecha' => sprintf('%s / %s', fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_inicio']), fecha($detallePlanificaciones['DetallesPlanificacione']['fecha_fin'])),
                    'cantidadPagosEI' => $cantidadPagosEI,
//                                    'detallePagos' => $detallePagos,
                    'etiqueta' => sprintf("'%s - %s'", $indicadores[$detallePlanificaciones['DetallesPlanificacione']['carteras_indicadores_id']], $detallePlanificaciones['Estrategia']['nombre']
                    ),
                );
            }
        }
        @$montoTotalEI = 0;
    }

    foreach ($pagosCantidad as $fecha => $cantidad) {
        $cantidadPagos[$fecha] = count(array_unique($cantidad));
    }

    /*
     * Muestro los pagos (monto y cantidad) realizados por dia
     */
    $htmlPagos = array();                     
    
    $tablaPagos[] = $this->Html->tag('thead', $this->Html->tableHeaders(array('Fecha', 'Cantidad', 'Importe')));   

    $graficaPagosXImporte = null;
    $graficaPagosXImporte['options']['title'] = 'Importe de Pagos por dia';
    $graficaPagosXImporte['divContenedor'] = sprintf('grafica_comportamiento_de_pagos_por_importe');
    $graficaPagosXImporte['tipoGrafica'] = 'BubbleChart';
    $graficaPagosXImporte['options']['hAxis']['title'] = 'Dia';
    $graficaPagosXImporte['options']['vAxis']['title'] = 'Importe';    

    $graficaPagosXImporte['items'][] = array(
        "'ID'",
        "'Dia'",
        "'Importe'",
        "'Fecha'",
    );

    $graficaPagosXCantidad = null;
    $graficaPagosXCantidad['options']['title'] = 'Cantidad de Pagos por dia';
    $graficaPagosXCantidad['divContenedor'] = sprintf('grafica_comportamiento_de_pagos_por_cantidad');
    $graficaPagosXCantidad['tipoGrafica'] = 'BubbleChart';
    $graficaPagosXCantidad['options']['hAxis']['title'] = 'Dia';
    $graficaPagosXCantidad['options']['vAxis']['title'] = 'Cantidad';

    $graficaPagosXCantidad['items'][] = array(
        "'ID'",
        "'Dia'",
        "'Cantidad'",
        "'Fecha'",
    );

    foreach ($pagos as $fecha => $monto) {
        $tablaPagos[] = $this->Html->tableCells(array(array($fecha,
                $cantidadPagos[$fecha],
                nro($monto),
            )
        ));
        $graficaPagosXImporte['items'][] = array(
            sprintf('"%s"', substr($fecha, 0, 2)),
            sprintf('%s', substr($fecha, 0, 2)),
            sprintf('%s', $monto),
            sprintf('"%s"', $fecha),
        );

        $graficaPagosXCantidad['items'][] = array(
            sprintf('"%s"', substr($fecha, 0, 2)),
            sprintf('%s', substr($fecha, 0, 2)),
            sprintf('%s', $cantidadPagos[$fecha]),
            sprintf('"%s"', $fecha),
        );
    }

    $tablaPagos[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(  
                                                                                    'TOTAL',
                                                                                    array_sum($cantidadPagos),
                                                                                    number_format(array_sum($pagos), 2, ',', '.')
                                                                                    )
    )));    
      
    $htmlPagos[] = $this->Html->div('grafica', '', array('id' => 'grafica_comportamiento_de_pagos_por_importe'));
    $htmlPagos[] = $this->Html->div('grafica', '', array('id' => 'grafica_comportamiento_de_pagos_por_cantidad'));    
    $htmlPagos[] = $this->Googlechart->paint($graficaPagosXImporte);
    $htmlPagos[] = $this->Googlechart->paint($graficaPagosXCantidad);   
    $htmlPagos[] = $this->Html->tag('table', implode("\n", $tablaPagos), array('class' => 'tablaInforme'));

    /*
     * Muestro el comportamiento de pagos de acuerdo a las estrategias de gestion - indicadores de recupero planificados 
     * (para cada detalle de planificacion realizado) hay que ver la cantidad de dias a tomar como regla de negocio!!!!!!!!!!   
     */
    $htmlPagosEI = array();
    $tablaPagosEI[] = $this->Html->tag('thead', $this->Html->tableHeaders(array('Indicador de recupero', 
                                                                                'Estrategia de gestion', 
                                                                                'Fecha', 
                                                                                'Cantidad', 
                                                                                'Importe'
                                                                                )
                                                                            ));

    $htmlPagosEI[] = $this->Html->div('grafica', '', array('id' => 'grafica_comportamiento_de_pagos_por_importe_EI'));

    $graficaImportePagosXEI = null;
    $graficaImportePagosXEI['options']['title'] = 'Importe de Pagos por dia por Indicadores de recupero / Estrategias de Gestion';
    $graficaImportePagosXEI['divContenedor'] = sprintf('grafica_comportamiento_de_pagos_por_importe_EI');
    $graficaImportePagosXEI['tipoGrafica'] = 'LineChart';
    $graficaImportePagosXEI['options']['hAxis']['title'] = 'Fecha';
    $graficaImportePagosXEI['options']['vAxis']['title'] = 'Importe';
//    d($pagosEI);
    $items = Set::extract($pagosEI, '{n}.etiqueta');
//    dd($items);
    array_unshift($items, "'Fecha'");
    $graficaImportePagosXEI['items'][] = $items;
    
    foreach ($pagosEI as $pago) {
        $tablaPagosEI[] = $this->Html->tableCells(array(array(
                $pago['indicador'],
                $pago['estrategia'],
                $pago['fecha'],
                $pago['cantidadPagosEI'],
                nro($pago['importe'])
            )
        ));
    }
    
    ksort($detallePagos);
    foreach ($detallePagos as $fecha => $detallePago) {
        $aux = array(
              sprintf("'%s'", fecha($fecha)), // => dia
        );

        foreach (array_unique($planificacionesId) as $id) {
            array_push($aux, (!empty($detallePago[$id])) ? $detallePago[$id] : 0);
        }
        $graficaImportePagosXEI['items'][] = $aux;
    }

    $tablaPagosEI[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array('',
            '',
            'TOTAL',
            array_sum(Set::extract($pagosEI, '{n}.cantidadPagosEI')),
            nro(array_sum(Set::extract($pagosEI, '{n}.importe'))),
        )
    )));
                   
    $htmlPagosEI[] = $this->Googlechart->paint($graficaImportePagosXEI);
    $htmlPagosEI[] = $this->Html->tag('table', implode("\n", $tablaPagosEI), array('class' => 'tablaInforme'));        
    
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlPagos));
    $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlPagosEI));

    $html[] = '</fieldset>';
    echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));
}

?>