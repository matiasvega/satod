<script>
    $(document).ready(function () {
//        $('select').chosen({width: "100%"});
//        $('#grafica').chosen({width: "100%"});
        var cloneCount = 0;
        $('#agregar_indicador').bind('click', function() {
            cloneCount++;
            $('#fila')
                    .clone()
                    .attr('id', 'fila' + cloneCount)
                    .insertAfter('[id^=fila]:last');
                    $(window).scrollTop($('#fila' + cloneCount).offset().top);
            $('.columna')
                    .last()
                    .attr('name', 'data[Cartera][Columna]['+ cloneCount + ']');
            $('.calculo')
                    .last()
                    .attr('name', 'data[Cartera][CalculoColumna]['+ cloneCount + ']')
                    .attr('id', 'CarteraCalculoColumna'+cloneCount)
                    .bind('change', function() {
                        console.log('#grafica'+cloneCount);
                        if ($(this).val() == 'group') {
                            $('#grafica'+cloneCount).attr('disabled', false);
                        } else {
                            $('#grafica'+cloneCount).attr('disabled', true);
                        }                        
                    });
            $('.etiqueta')
                    .last()
                    .attr('name', 'data[Cartera][EtiquetaColumna]['+ cloneCount + ']')
                    .attr('id', 'CarteraEtiquetaColumna'+ cloneCount)
                    .val('');
            $('.grafica')
                    .last()
                    .attr('name', 'data[Cartera][GraficaColumna]['+ cloneCount + ']')
                    .attr('id', 'grafica'+ cloneCount)
                    .attr('disabled', true);                    
        });
        
        $('.calculo').bind('change', function() {                
                var id = '#grafica';
                if ($(this).val() == 'group') {
                    $(id).attr('disabled', false);
                } else {
                    $(id).attr('disabled', true);
                }            
        });
    
        
    });

</script>
<?php

if (isset($columnas)) {
    
    echo $this->Form->input(
                            'Cartera.totalDeuda',
                            array(
                                    'empty' => 'Selecciona el campo correspondiente',
                                    'default' => 'empty',
                                    'options' => $columnas,
                                    'label' => 'Elegi el campo que representa la deuda en $:',
                                    'required' => true,
                                    'div' => 'required',
                                    'id' => 'totalDeuda',
                                    )
                            );
    
    
//    dd($columnas);
    echo $this->Html->tag('h1', 'Crear Indicadores de Recupero');
    echo '<table cellpadding="0" cellspacing="0">';
    echo $this->Html->tableHeaders(array('Columna', 'Calculo', 'Etiqueta', 'Grafica'));

    // Defino en duro los posibles calculos que se pueden realizar para definir indicadores de recupero particulares de la cartera que
    // se esta cargando.
    $opcionesColumna = array(
                                'sum' => 'SUMA',
                                'avg' => 'PROMEDIO',
                                'group' => 'GRUPO'
                            );
    
    // Defino las posibles graficas que pueden realizarse.
    $opcionesGrafica = array(
                                'BarChart' => 'Barras',
                                'PieChart' => 'Torta',
                                'GeoChart' => 'Geografico',
                                'ComboChart' => 'Combo',
                                'ColumnChart' => 'Columnas',
                                'AreaChart' => 'Areas',
                            );
    
    echo $this->Html->tableCells(array(
            array(
                $this->Form->input(
                                    'Cartera.Columna.0',
                                    array(
                                            'label' => false,
                                            'default' => 'empty',
//                                            'data-placeholder' => 'Elegi el dato',
                                            'options' => $columnas,
                                            'class' => 'columna',
                                        ) 
                                    ),
                $this->Form->input(
                                    'Cartera.CalculoColumna.0', 
                                    array(
                                            'label' => false, 
                                            'options' => $opcionesColumna, 
                                            'default' => 'empty',
//                                            'multiple' => true,
//                                            'data-placeholder' => 'Elegi los calculos que desees realizar',
                                            'class' => 'calculo',
                                            )
                                    ),
                $this->Form->input(
                                    'Cartera.EtiquetaColumna.0', 
                                    array(
                                            'label' => false,
                                            'class' => 'etiqueta',
                                            'required' => 'true',
                                            'placeholder' => 'Etiqueta que identifique al indicador.',
                                            )
                                        ),
                $this->Form->input(
                                    'Cartera.GraficaColumna.0', 
                                    array(
                                            'label' => false, 
                                            'options' => $opcionesGrafica, 
                                            'default' => 'empty',
//                                            'multiple' => 'checkbox',
//                                            'multiple' => true,
//                                            'data-placeholder' => 'Elegi los calculos que desees realizar',
                                            'class' => 'grafica',
                                            'id' => 'grafica',
                                            'disabled' => true,
                                            )
                                    ),
                )
        ), array('id' => 'fila'));

    echo '</table>';
    
    echo $this->Form->button(
                            'Agregar Indicador', 
                            array(
                                    'label' => false,
                                    'type' => 'button',
                                    'id' => 'agregar_indicador',
                                    )
                                );    
}

?>