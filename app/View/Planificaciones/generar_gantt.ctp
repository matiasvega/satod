<?php

echo "
    <script type=\"text/javascript\">
        $(document).ready(function() {

            $('.tablaInforme').dataTable({
                'bJQueryUI': true,
                'bPaginate': true,
                'bLengthChange': false,
                'bFilter': false,
                'bSort': true,
//                'bInfo': false,
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
        echo $this->Session->flash();
        $html[] = '<fieldset spellcheck="true" class="fieldsetInforme" >';
        $html[] = '<legend> Planificacion de gestion de Cartera de Deudores</legend>';              

        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Empresa Cliente: %s', ucfirst($datos['Planificacion']['Cartera']['Cliente']['nombre'])));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Cartera: %s', ucfirst($datos['Planificacion']['Cartera']['nombre'])));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha de inicio: %s', 
                                                    fecha($datos['Planificacion']['Planificacione']['fecha_inicio'])));
        $htmlEncabezado[] = $this->Html->tag('h1', sprintf('Fecha de fin: %s', 
                                                    fecha($datos['Planificacion']['Planificacione']['fecha_fin'])));

        $html[] = $this->Html->div('encabezado', implode("\n", $htmlEncabezado));
        
        // Muestro una grilla con la planificacion realizada (fecha y estrategia por indicador de recupero)
        $htmlDetallesPlanificacion = array();                          
        $htmlDetallesPlanificacion[] = $this->Html->tag('h2', 'Detalle de planificacion');
        
        // Muestro la grafica de gantt
        $graficaPlanificacion = null;
        $graficaPlanificacion['options']['title'] = 'Planificacion';
        $graficaPlanificacion['options']['height'] = (80*count($datos['Planificacion']['DetallesPlanificacione']));
        $graficaPlanificacion['divContenedor'] = 'graficaGantt';
        $graficaPlanificacion['tipoGrafica'] = 'Timeline';

        // Muestro la tabla con los datos
        $tablaHtmlDetallePlanificacion[] = $this->Html->tag('thead', $this->Html->tableHeaders(array(
                                '',
                                'INDICADOR', 
                                'ESTRATEGIA',
                                'FECHA INICIO', 
                                'FECHA FIN'
                    )));
                        
        foreach ($datos['Planificacion']['DetallesPlanificacione'] as $k => $detalle) {            
            $tablaHtmlDetallePlanificacion[] = $this->Html->tableCells(array(array(
                    $k+1, 
                    $datos['IndicadoresSeleccionados'][$detalle['carteras_indicadores_id']], 
                    $detalle['Estrategia']['nombre'], 
                    fecha($detalle['fecha_inicio']),
                    fecha($detalle['fecha_fin']),
            )));
        }

        $htmlDetallesPlanificacion[] = $this->Html->tag('table', implode("\n", $tablaHtmlDetallePlanificacion), array('class' => 'tablaInforme'));
                                                
        $html[] = $this->Html->div('contenedorIndicadores', implode("\n", $htmlDetallesPlanificacion));
        
        $html[] = $this->Html->div('graficaGantt', '', array('id' => 'graficaGantt'));
        $graficaPlanificacion['items'][] = $datos['Gantt'];
        $html[] = $this->Googlechart->paint($graficaPlanificacion);
                
        $html[] = '</fieldset>';
        echo $this->Html->div('contenedorReporte', implode("\n", $html), array('id' => 'contenedorReporte'));
    }

//    function ChartTimeLine($options = array()) {        
//        $script = sprintf("                  
//            
//            <script type=\"text/javascript\">
//            google.load('visualization', '1', {'packages':['timeline'], \"callback\": drawChart});
//            google.setOnLoadCallback(drawChart);
//            function drawChart() {
//
//                var container = document.getElementById('graficaGantt');
//                var chart = new google.visualization.Timeline(container);
//
//                var dataTable = new google.visualization.DataTable();
//                dataTable.addColumn({ type: 'string', id: 'Term' });
//                dataTable.addColumn({ type: 'string', id: 'Name' });
//                dataTable.addColumn({ type: 'date', id: 'Start' });
//                dataTable.addColumn({ type: 'date', id: 'End' });
//
//                dataTable.addRows(%s);
//
//                var options = {
//                    'width':1000,
//                    'height':(48*%s),
//                    timeline: { showRowLabels: true,
//                                groupByRowLabel: true,
//                                }
//                };
//
//
//                chart.draw(dataTable, options);
//            }
//            </script>
//            ", 
//            sprintf('[%s]', implode(',', $options['Gantt'])),
//            count($options['Gantt'])
//        );
//        return $script;
//    }
    
?>