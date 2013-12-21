<?php
App::uses('AppHelper', 'View/Helper');

class GooglechartHelper extends AppHelper {
    protected $_data = array();
    
    protected $_grafica = array(
                'LineChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                                        'selectionMode' => 'multiple',
                                        'title' => "TITULO",
                                        'curveType' => 'none',
                                        'pointSize' => '7',
                                        'hAxis' => array(
                                            'title' => "",
                                        ),
                                        'vAxis' => array(
                                            'title' => "",
                                        ),
                                        'legend' => array('position' => 'bottom'),
                                        'height' => '400',
                                        'width' => '1100',
                                        'backgroundColor' => 'transparent',
                                        'sizeAxis' => array('maxSize' => '15'),
                    ),
                ),
                'ColumnChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                        'title' => "TITULO",
                        'backgroundColor' => 'transparent',
                        'hAxis' => array(
                            'title' => "",
                        ),
                        'vAxis' => array(
                            'title' => "",
                        ),
                        'legend' => array('position' => 'right'),
                        'series' => array('color' => 'red'),
                        'height' => '400',
                        'width' => '1100',
                    ),
                ),
                'BarChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                        'title' => "TITULO",
                        'backgroundColor' => 'transparent',
                        'hAxis' => array(
                            'title' => "",
                            'gridlines' => array('count' => -1),
                        ),
                        'vAxis' => array(
                            'title' => "",
                        ),
                        'legend' => array('position' => 'right'),
                        'series' => array('color' => 'red'),
                        'height' => 400,
                    ),
                ),
                'BubbleChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                        'selectionMode' => 'multiple',
                        'backgroundColor' => 'transparent',
                        'title' => "",
                        'hAxis' => array(
                            'title' => "",
                            'format' => '#',
                            'gridlines' => array(
                                                    'count' => '12',
                                                ),
                        ),
                        'vAxis' => array(
                            'title' => "",
                        ),
                        'legend' => array('position' => 'none'),
                        'height' => '400',
                        'width' => '1100',
                        'sizeAxis' => array('maxSize' => '15'),
                    ),
                ),
                'GeoChart' => array(
                    'packages' => 'geochart',
                    'options' => array(
                        'region' => 'AR',
                        'displayMode' => 'regions',
                        'resolution' => 'provinces',
                        'backgroundColor' => 'transparent',
                        'height' => '400',
                        'width' => '900',  
                        'colorAxis' => array(
                            'colors' => array('green', 'red'),
                        ),
                    ),
                ),
                'PieChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                        'title' => "",
                        'backgroundColor' => 'transparent',
                        'is3D' => true,
                    ),
                ),
                'ComboChart' => array(
                    'packages' => 'corechart',
                    'options' => array(
                        'hAxis' => array(
                                            'title' => "",
                                        ),
                        'vAxis' => array(
                                            'title' => "",
                                        ),
                        'legend' => array('position' => 'none'),
                        'backgroundColor' => 'transparent',
                        'series' => array('color' => 'red'),
                        'height' => '400',
                    ),
                ),
                'Timeline' => array(
                    'packages' => 'timeline',
                    'options' => array(
                        'height' => '300',
                        'width' => '1100',
                    ),
                ),        
                'TreeMap' => array(
                    'packages' => 'treemap',
                    'options' => array(
                        'height' => '300',
                        'width' => '1100',
                    ),
                ),
                
    );
        
    public function paint($grafica = array()) {
//        d($grafica);
        foreach ($grafica['items'] as $valores) {
            $datos[] = sprintf("[%s]", implode(',', $valores));
        }
        
        if ($grafica['tipoGrafica'] == 'Timeline') {
            $datos = sprintf("%s", implode(',', $datos));
        } else {
            $datos = sprintf("[%s]", implode(',', $datos));
        }         
//        d($datos);
//        dd($this->_grafica);
        
        $script = sprintf("            
            <script type=\"text/javascript\">
                // Load the Visualization API and the piechart package.
                google.load('visualization', '1', {'packages':['%s'], \"callback\": drawChart});

                // Set a callback to run when the Google Visualization API is loaded.
                google.setOnLoadCallback(drawChart);   

                function drawChart() {
                    // Create the data table.
                    if ('%s' == 'Timeline') {
                        var data = new google.visualization.DataTable();
                        data.addColumn({ type: 'string', id: 'Term' });
                        data.addColumn({ type: 'string', id: 'Name' });
                        data.addColumn({ type: 'date', id: 'Start' });
                        data.addColumn({ type: 'date', id: 'End' });

                        data.addRows(%s);
                    } else {
                        var data = google.visualization.arrayToDataTable(%s);
                    }
                    
                    // Set chart options
                    var options = %s;

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.%s(document.getElementById('%s'));
                    chart.draw(data, options);
                }                    
              </script>", 
                $this->_grafica[$grafica['tipoGrafica']]['packages'],
                $grafica['tipoGrafica'], 
                $datos, 
                $datos, 
                json_encode(array_merge(
                                        $this->_grafica[$grafica['tipoGrafica']]['options'], 
                                        (!empty($grafica['options']))?$grafica['options']:array()
                                        )
                            ), 
                $grafica['tipoGrafica'], 
                $grafica['divContenedor']);                
                
        return $script;
    }
    
    
}
?>
