<?php

echo '
    <html>
        <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<title>
                        V/N Sistema de apoyo a la toma de decisiones:
                        Planificaciones	</title>
                <script src="https://www.google.com/jsapi"></script>
                

<link rel="stylesheet" type="text/css" href="http://localhost/devel/satod/css/cake.generic.css" />

        
        </head>
        <body>
        <div id="headerpdf">
                <div id="logo"> <img src="http://localhost/devel/satod/img/logo-vn-trans.png" /> </div>
                <div id="texto"> Business Process Outsourcing </div>
            </div>
            
            <div id="clearpdf"> </div>
';

if (isset($datos)) {
    /*
     * Muestro el encabezado
     */
    $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" id="fieldsetInforme" >';
    $html[] = '<legend id="titulo"> Informe de Analisis de Cartera de Deudores</legend>';

    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos['Cliente']['nombre']));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos['Cartera']['nombre']));

    $html[] = $this->Html->div('encabezado', implode("\n", $htmlEncabezado), array('id' => 'encabezado'));

    /*
     * Muestro los indicadores de recupero
     */
    $htmlIndicadoresGenerales = array();
    $htmlIndicadoresGenerales[] = $this->Html->tag('h2', 'Indicadores generales de recupero');

    $htmlIndicadoresParticulares = array();
    $htmlIndicadoresParticulares[] = $this->Html->tag('h2', 'Indicadores particulares de recupero');

    if (!empty($datos['Indicadore'])) {
        foreach ($datos['Indicadore'] as $indicador) {
            $tablaHtmlIndicadoresParticularesGrupo = array();
            if ($indicador['tipo'] == 'P') {
                if ($indicador['calculo'] != 'group') {
                    $htmlIndicadoresParticulares[] = $this->Html->div('indicadorResultado', sprintf('%s : %s', $indicador['etiqueta'], nro($indicador['IndicadoresValore'][0]['valor_ponderado'])));
                } else {
                    
                    $htmlIndicadoresParticularesGrupo[] = $this->Html->tag('div', $indicador['etiqueta'], array('class' => 'indicadorResultado'));
                                        
                    // Muestro la grafica
                    $graficaIndicadorParticular = null;
                    $graficaIndicadorParticular['options']['title'] = $indicador['etiqueta'];
                    $graficaIndicadorParticular['options']['width'] = '1100';
                    $graficaIndicadorParticular['divContenedor'] = sprintf('grafica_%s', strtolower(str_replace(' ', '_', $indicador['etiqueta'])));
                    $graficaIndicadorParticular['tipoGrafica'] = $indicador['grafica'];

                    if($indicador['grafica'] == 'ComboChart') {
                        $graficaIndicadorParticular['options']['hAxis']['title'] = $indicador['etiqueta'];
                        $graficaIndicadorParticular['options']['vAxis']['title'] = 'Deuda';
                    }


                    $htmlIndicadoresParticularesGrupo[] = $this->Html->div('grafica', '', array('id' => $graficaIndicadorParticular['divContenedor'], 'class' => 'graficaIndicadores'));
                    // Muestro la tabla con los datos
                    $tablaHtmlIndicadoresParticularesGrupo[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                                ucwords($indicador['etiqueta']),
                                'DEUDA',
                                '% INCIDENCIA',
                                'COMISION',
                    )));

                    $totalDeuda = array_sum(Set::extract($indicador['IndicadoresValore'], '{n}.valor_ponderado'));
                    $incidencia = null;
                    $graficaIndicadorParticular['items'][] = array(
                                                                    sprintf("'%s'", $indicador['etiqueta']), 
                                                                    "'Deuda'"
                                                                    );
                    foreach ($indicador['IndicadoresValore'] as $valores) {
                        $tablaHtmlIndicadoresParticularesGrupo[] = $this->Html->tableCells(array(array(
                                $valores['valor'],
                                round($valores['valor_ponderado'], 2),
                                sprintf('%s', round((($valores['valor_ponderado'] / $totalDeuda) * 100), 2)),
                                round((($valores['valor_ponderado'] * $datos['Cartera']['comision']) / 100), 2),
                        )));
                        $incidencia[] = (($valores['valor_ponderado'] / $totalDeuda) * 100);
                        $comision[] = (($valores['valor_ponderado'] * $datos['Cartera']['comision']) / 100);
                        $graficaIndicadorParticular['items'][] = array(
                                                                        sprintf("'%s'", $valores['valor']), 
                                                                        round($valores['valor_ponderado'], 2)
                                                                        );
                    }
                    $tablaHtmlIndicadoresParticularesGrupo[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                                    'TOTAL',
                                    number_format($totalDeuda, 2, ',', '.'),
                                    sprintf('%s %%', array_sum($incidencia)),
                                    number_format(array_sum($comision), 2, ',', '.'),
                    ))));

                    $htmlIndicadoresParticularesGrupo[] = $this->Html->tag('table', implode("\n", $tablaHtmlIndicadoresParticularesGrupo), array('class' => 'tablaInforme'));
                    $htmlIndicadoresParticularesGrupo[] = $this->Googlechart->paint($graficaIndicadorParticular);                
                }
            } else if ($indicador['tipo'] == 'G') {
                foreach ($indicador['IndicadoresValore'] as $indicadoreValores) {
                    if ($indicadoreValores['id'] == $indicador['CarterasIndicadore']['indicadores_valores_id']) {
                        $htmlIndicadoresGenerales[] = $this->Html->tag('div', sprintf('%s : %s', $indicador['etiqueta'], $indicadoreValores['valor']), array('class' => 'indicador'));
                        $valoresPonderados[] = $indicadoreValores['valor_ponderado'];
                    }
                }
            }
        }        
       /*
        * Muestro el porcentaje de recupero estimado para la cartera de acuerdo a los valores ponderados de los indicadores generales
        */
       $htmlIndicadoresGenerales[] = $this->Html->tag('div', sprintf('%s : %s', 'Porcentaje estimado de recupero', array_sum($valoresPonderados) . '%.'), array('class' => 'indicadorResultado'));

       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresGenerales));
       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresParticulares));
       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresParticularesGrupo));
       
    } else {        
        die('ERROR: No se encontraron indicadores de recupero definidos.');
    }
    
    
    if (!empty($costosEstrategias)) {
        /*
         * Muestro los costos de aplicar las estrategias seleccionadas
         */
        $html[] = $this->Html->tag('h2', 'Costos de gestionar asignacion', array('id' => 'informeAnalizarCostos'));

        $countCostoEstrategia = 0;
        foreach ($costosEstrategias as $estrategia) {
            $CostoEstrategia = 0;
            $tablaEstrategia = array();
            $tablaEstrategia[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                        ucwords($estrategia['Estrategia']['nombre']),
                        "Costo",
            )));
            $graficaCostoEstrategia[$countCostoEstrategia]['options']['title'] = ucwords($estrategia['Estrategia']['nombre']);

            $htmlEstrategia[] = $this->Html->tag('div', sprintf('Estrategia: %s', $estrategia['Estrategia']['nombre']), array('class' => 'indicadorResultado'));
            
            foreach ($estrategia['Costo'] as $costo) {                
                
                $tablaEstrategia[] = $this->Html->tableCells(array(array(
                        $costo['nombre'],
                        nro(($costo['tipo'] == 'F') ? $costo['valor'] : ($costo['valor'] * $costo['CostosEstrategia']['multiplicador'])),
                )));

                $CostoEstrategia += ($costo['tipo'] == 'F') ? $costo['valor'] : ($costo['valor'] * $costo['CostosEstrategia']['multiplicador']);

    //            $graficaCostoEstrategia[$countCostoEstrategia]['items'][$costo['nombre']] = ($costo['tipo'] == 'F') ? $costo['valor'] : ($costo['valor'] * $costo['CostosEstrategia']['multiplicador']);

                $graficaCostoEstrategia[$countCostoEstrategia]['items'][] = array(
                    sprintf("'%s'", $costo['nombre']),
                    ($costo['tipo'] == 'F') ? $costo['valor'] : ($costo['valor'] * $costo['CostosEstrategia']['multiplicador'])
                );


            }

            $tablaEstrategia[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                            'TOTAL',
                            nro($CostoEstrategia),
            ))));
                                                        
                    
            $htmlEstrategia[] = $this->Html->tag('table', implode("\n", $tablaEstrategia), array('class' => 'tablaInforme'));

            $graficaCostoEstrategia[$countCostoEstrategia]['divContenedor'] = sprintf('grafica_%s', strtolower(str_replace(' ', '_', $estrategia['Estrategia']['nombre'])));
            $graficaCostoEstrategia[$countCostoEstrategia]['tipoGrafica'] = 'PieChart';

            $htmlEstrategia[] = $this->Html->div('grafica', '', array('id' => $graficaCostoEstrategia[$countCostoEstrategia]['divContenedor']));
            $htmlEstrategia[] = $this->Googlechart->paint($graficaCostoEstrategia[$countCostoEstrategia]);        
            $htmlEstrategia[] = $this->Html->tag(
                    'div', 
                    sprintf('Rentabilidad de aplicar estrategia: %s', nro((($totalDeuda * $datos['Cartera']['comision']) / 100) - $CostoEstrategia)),
                    array('class' => 'rentabilidad')
            );

            $countCostoEstrategia++;
        }

        $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlEstrategia));        
    }
    

    $html[] = '</fieldset>';
    echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));
}

    echo '
            </body>
        </html>
        ';    
    
?>
