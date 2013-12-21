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

        // Muestro el encabezado
        $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" >';
        $html[] = '<legend> Presupuesto de Gestión de Cartera de Deudores</legend>';
                
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos['Cliente']['nombre']));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos['Cartera']['nombre']));

        $html[] = $this->Html->div('encabezado', implode("\n", $htmlEncabezado));
        
        // Muestro los indicadores de recupero
        $htmlIndicadoresGenerales = array();
        $htmlIndicadoresParticulares = array();                        
        
        if (!empty($datos['Indicadore'])) {
            $htmlIndicadoresGenerales[] = $this->Html->tag('h2', 'Indicadores generales de recupero');        
            $htmlIndicadoresParticulares[] = $this->Html->tag('h2', 'Indicadores particulares de recupero');
            
            foreach ($datos['Indicadore'] as $indicador) {
                if ($indicador['tipo'] == 'P') {
                    if ($indicador['calculo'] != 'group') {
                        $htmlIndicadoresParticulares[] = $this->Html->div('indicadorResultado', sprintf('%s : %s', $indicador['etiqueta'], number_format($indicador['IndicadoresValore'][0]['valor_ponderado'], 2, ',', '.')));
                    }
                } else if ($indicador['tipo'] == 'G') {
                    foreach ($indicador['IndicadoresValore'] as $indicadoreValores) {
                        if($indicadoreValores['id'] == $indicador['CarterasIndicadore']['indicadores_valores_id']) {
                            $htmlIndicadoresGenerales[] = $this->Html->tag('div',  sprintf('%s : %s', $indicador['etiqueta'], $indicadoreValores['valor']), array('class' => 'indicador'));
                            $valoresPonderados[] = $indicadoreValores['valor_ponderado'];
                        }
                    }                                               
                }
            }     

            /*
             * Muestro el porcentaje de recupero estimado para la cartera de acuerdo a los valores 
             * ponderados de los indicadores generales
            */
            $htmlIndicadoresGenerales[] = $this->Html->tag('div', sprintf('%s : %s', 'Porcentaje estimado de recupero', array_sum($valoresPonderados) . '%.'), array('class' => 'indicadorResultado'));

            $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresGenerales));
//            $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresParticulares));
        } else {        
            die('ERROR: No se encontraron indicadores de recupero definidos.');
        }
               
    if (!empty($costosEstrategias)) {
        /*
         * Muestro los costos de aplicar las estrategias seleccionadas
         */
        $html[] = $this->Html->tag('h2', 'Costos de gestionar asignacion');

        $countCostoEstrategia = 0;
        $costoTotal = array();            
        foreach ($costosEstrategias as $estrategia) {
            $CostoEstrategia = 0;
            $tablaEstrategia = array();
            $tablaEstrategia[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                        ucwords($estrategia['Estrategia']['nombre']),
                        "Costo",
            )));
            
            $htmlEstrategia[] = $this->Html->tag('div', sprintf('Estrategia: %s', $estrategia['Estrategia']['nombre']), array('class' => 'indicadorResultado'));
            
            $graficaCostoEstrategia[$countCostoEstrategia]['options']['title'] = ucwords($estrategia['Estrategia']['nombre']);

            
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
            $costoTotal[] = $CostoEstrategia;
            $tablaEstrategia[] = $this->Html->tag('tfoot', $this->Html->tableCells(array(array(
                            'TOTAL',
                            nro($CostoEstrategia),
            ))));

            $htmlEstrategia[] = $this->Html->tag('table', implode("\n", $tablaEstrategia), array('class' => 'tablaInforme'));

            $graficaCostoEstrategia[$countCostoEstrategia]['divContenedor'] = sprintf('grafica_%s', strtolower(str_replace(' ', '_', $estrategia['Estrategia']['nombre'])));
            $graficaCostoEstrategia[$countCostoEstrategia]['tipoGrafica'] = 'PieChart';

            $htmlEstrategia[] = $this->Html->div('grafica', '', array('id' => $graficaCostoEstrategia[$countCostoEstrategia]['divContenedor']));
            $htmlEstrategia[] = $this->Googlechart->paint($graficaCostoEstrategia[$countCostoEstrategia]);        

            $countCostoEstrategia++;
        }
        
        $htmlEstrategia[] = $this->Html->tag('div', sprintf('%s : %s', 'COSTO TOTAL', nro(array_sum($costoTotal))), array('class' => 'indicadorResultado'));
        
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
