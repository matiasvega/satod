<?php
/*
 * Me fijo la deuda para cada indicador de recupero, mostrando el top five de los valores 
 * que mas adeudan por cada indicador de recupero.
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

if (isset($datos)) {
    /*
     * Muestro el encabezado
     */
    $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" id="fieldsetInforme" >';
    $html[] = '<legend id="titulo"> Scoring de Deudores </legend>';

    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha: %s', date("d-m-Y")));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', $datos['Cliente']['nombre']));
    $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Cartera: %s', $datos['Cartera']['nombre']));

    $html[] = $this->Html->div('encabezado', implode("\n", $htmlEncabezado), array('id' => 'encabezado'));
           
    
    /*
     * Muestro los indicadores de recupero
     */
//    $htmlIndicadoresGenerales = array();
//    $htmlIndicadoresGenerales[] = $this->Html->tag('h2', 'Indicadores generales de recupero');
//dd($datos['Indicadore']);
    $htmlIndicadoresParticulares = array();
    $htmlIndicadoresParticulares[] = $this->Html->tag('h2', 'Indicadores particulares de recupero');

    if (!empty($datos['Indicadore'])) {
        $dataTreeMap[] = array(
                                'indicador' => sprintf("'%s'", "Location"),
                                'parent' => sprintf("'%s'", "parent"),
                                'size' => sprintf("'%s'", "size"),
                                'color' => sprintf("'%s'", "color"),
                            );
        $dataTreeMap[] = array(
                                'indicador' => sprintf("'%s'", $datos['Cartera']['nombre']),
                                'parent' => "null",
                                'size' => 0,
                                'color' => 0,
                            );
//        $dataTreeMap['indicador'] = "Global";
//        $dataTreeMap['parent'] = "null";
//        $dataTreeMap['size'] = 0;
//        $dataTreeMap['color'] = 0;
        foreach ($datos['Indicadore'] as $indicador) {
            $tablaHtmlIndicadoresParticularesGrupo = array();
            if ($indicador['tipo'] == 'P' && $indicador['calculo'] == 'group') {
//                    dd($indicador);
                    $dataTreeMap[] = array(
                                'indicador' => sprintf("'%s'", $indicador['etiqueta']),
                                'parent' => sprintf("'%s'", $datos['Cartera']['nombre']),
                                'size' => 0,
                                'color' => 0,
                            );
//                    $dataTreeMap['indicador'] = $indicador['etiqueta'];
//                    $dataTreeMap['parent'] = "Global";
//                    $dataTreeMap['size'] = 0;
//                    $dataTreeMap['color'] = 0;
                    foreach ($indicador['IndicadoresValore'] as $indicadorValor) {
//                        $x[$indicador['etiqueta']][$indicadorValor['valor']] = $indicadorValor['valor_ponderado'];
                        
                        $dataTreeMap[] = array(
                                'indicador' => sprintf("'%s'", $indicadorValor['valor']),
                                'parent' => sprintf("'%s'", $indicador['etiqueta']),
                                'size' => $indicadorValor['valor_ponderado'],
                                'color' => $indicadorValor['valor_ponderado'],
                            );
                        
//                        $dataTreeMap['indicador'] = $indicadorValor['valor'];
//                        $dataTreeMap['parent'] = $indicador['etiqueta'];
//                        $dataTreeMap['size'] = $indicadorValor['valor_ponderado'];
//                        $dataTreeMap['color'] = $indicadorValor['valor_ponderado'];
                    }
//                    arsort($x[$indicador['etiqueta']]);
            }
        }
        
//        dd($dataTreeMap);
        
        $htmlIndicadoresParticularesGrupo[] = $this->Html->tag('div', '', array('id' => 'contenedorGrafica'));
        
        $graficaScoring = null;
//        $graficaScoring['options']['title'] = '';
//        $graficaScoring['options']['width'] = '1100';
        $graficaScoring['divContenedor'] = 'contenedorGrafica';
        $graficaScoring['tipoGrafica'] = 'TreeMap';
        $graficaScoring['options']['minColor'] = '#f00';
        $graficaScoring['options']['midColor'] = '#ddd';
        $graficaScoring['options']['maxColor'] = '#0d0';
        $graficaScoring['options']['headerHeight'] = '15';
        $graficaScoring['options']['fontColor'] = 'black';
        $graficaScoring['options']['showScale'] = true;
        $graficaScoring['items'] = $dataTreeMap;
        
        $htmlIndicadoresParticularesGrupo[] = $this->Googlechart->paint($graficaScoring);
        

//       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresGenerales));
//       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresParticulares));
       $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlIndicadoresParticularesGrupo));
       
    } else {        
        die('ERROR: No se encontraron indicadores de recupero definidos.');
    }
    
    
    $html[] = '</fieldset>';
    echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));
}

?>
