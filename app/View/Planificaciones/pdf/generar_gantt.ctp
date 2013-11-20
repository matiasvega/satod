<?php
//pr($datos);
//echo sprintf('[%s]', implode(',', $datos));
//die;


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

    
    echo '
            </body>
        </html>
        ';    
    
?>